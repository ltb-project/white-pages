// Default location when we can't geocode an address
const defaultLocation = { lat: mapDefaultLocationLat, lon: mapDefaultLocationLong }

// Center map on initialization
const initialLat = 37.99616267972814
const initialLon = 10.898437500000002
const initialZoom = 2

// Global variables
let mymap = null // Leaflet Map Object
let markerClusters // To store marker groups
let markers = [] // To store all markers to be able to calculate map bounds
let lastMapRecenter = Date.now() // Last time map has been recentered on points

// Map initialization
const initMap = () => {
  // Create "mymap" object and insert it in HTML element with id "map"
  mymap = L.map('map').setView([initialLat, initialLon], initialZoom)

  // We need to inform leaflet which tileserver we want to use.
  L.tileLayer(mapTileserver, {
    attribution: mapAttribution,
    minZoom: 1,
    maxZoom: 20
  }).addTo(mymap)

  // Now initialize marker groups
  markerClusters = L.markerClusterGroup()
  mymap.addLayer(markerClusters)
}

// Recalculate map zoom and position to show all markers
const recenterMapOnMarkers = () => {
  let group = new L.featureGroup(markers) // Create a marker group to adapt zoom
  mymap.fitBounds(group.getBounds().pad(0.2)) // Adjust map zoom so that all markers are visible
}

// Add a marker on map
const addMarkerOnMap = async (point) => {
  let opts = {}

  // Here we define icon to use with size (iconSize), position (iconAnchor) and popup position (popupAnchor)
  if (mapDisplayPhotosAsMarker) {
    opts.icon = L.icon({
      iconUrl: 'photo.php?dn=' + encodeURI(point.dn),
      iconSize: [40, 40],
      iconAnchor: [-6, 46],
      shadowUrl: 'images/map-shadow.png',
      shadowSize: [50, 50],
      shadowAnchor: [0, 50],
      popupAnchor: [25, -50]
    })
  }

  // Add marker to map
  let marker = L.marker(new L.LatLng(point.location.lat, point.location.lon), opts)

  // Add popup to marker
  let popupContent = `<p class="text-center"><b>${point.fullname}</b></p>
    ${point.additional_items.join('<br />')}${point.additional_items.length !== 0 ? '<br />' : ''}
    <a href="index.php?page=display&dn=${encodeURI(point.dn)}" >
    <img src="photo.php?dn=${encodeURI(point.dn)}" width=150px></img>
    </a>
    <p><i>${point.display_address}</i></p>`
  marker.bindPopup(popupContent)

  // Add marker to groups
  markerClusters.addLayer(marker)
  markers.push(marker)

  // Refresh map zoom and position after each marker has been added and at most twice per second
  const myTime = Date.now()
  if ((myTime - lastMapRecenter) > 500) {
    lastMapRecenter = myTime
    recenterMapOnMarkers()
  }
}

const geocode = (point) => {
  return new Promise(function (resolve, reject) {
    let xhr = new XMLHttpRequest()
    let url = 'geocode.php?q=' + point.address
    xhr.open('GET', url)
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        resolve(xhr.response)
      } else {
        reject({
          status: xhr.status,
          statusText: xhr.statusText
        })
      }
    }
    xhr.onerror = function () {
      reject({
        status: xhr.status,
        statusText: xhr.statusText
      })
    }
    xhr.send()
  })
}

const handlePoint = async (point) => {
  if (point.location) {
    return addMarkerOnMap(point)
  } else if (point.address) {
    return geocode(point)
      .then(function (datum) {
        point.location = JSON.parse(datum)[0]
        if (point.location === undefined) {
          if (mapNoLocationShowOnDefault) {
            console.warn('Unknown location for address "' + point.address + '" for "' + point.fullname + '".\nUsing default location.')
            point.location = defaultLocation
          } else {
            return
          }
        }
        addMarkerOnMap(point)
      })
      .catch(function (err) {
        console.error('There was an error ', err.status, ': ', err.statusText)
      })
  } else {
    if (mapNoLocationShowOnDefault) {
      point.location = defaultLocation
      return addMarkerOnMap(point)
    }
  }
}

window.onload = async () => {
  // Init function
  initMap()
  // Add location coordinates for each addresses
  await Promise.allSettled(interestPoints.map(handlePoint))
  // Refresh map zoom and position once all marker have been added
  recenterMapOnMarkers()
}
