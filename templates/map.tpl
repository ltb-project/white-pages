
{if {$size_limit_reached}}
<div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$msg_sizelimit}</div>
{/if}

<div class="row" style="height: calc(100vh - 200px); margin-left: 5px; margin-right: 5px;">
  <div id="map" style="height: 100%;"></div>
</div>


    <script src="vendor/leaflet/leaflet.js"></script>
    <script src="vendor/leaflet.markercluster/leaflet.markercluster.js"></script>

    <script type="text/javascript">
        var interestPoints={$interest_points nofilter};
        const mapTileserver='{$map_tileserver nofilter}';
        const mapAttribution='{$map_attribution nofilter}';
        const mapDisplayPhotosAsMarker={$map_display_photos_as_marker|var_export:true}
        const mapNoLocationShowOnDefault={$map_no_location_show_on_default|var_export:true};
        const mapDefaultLocationLat={$map_default_location_lat};
        const mapDefaultLocationLong={$map_default_location_long};
    </script>
    <script src="js/map.js"></script>
