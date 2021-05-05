

document.getElementById("thumbnailPhoto").onchange = function() {

    var photo = document.getElementById("thumbnailPhoto").files[0];
    
    if(photo.size > 100000){
        alert("Fichier trop lourd. 100ko maximum.");
        document.getElementById("thumbnailPhoto").value = "";
        return false;
    };

    var extension = photo.name.split('.').pop();
    var validExt = ['jpg', 'jpeg'];

    if(validExt.indexOf(extension) <= -1){
        alert("Image .jpg ou .jpeg demandée.");
        document.getElementById("thumbnailPhoto").value = "";
        return false;
    }

    document.getElementById("profilepic").src = URL.createObjectURL(photo);

};

document.getElementById("modify").onclick = function () {
    //alert("Here");
    document.getElementById("thumbnailPhoto").disabled = false;
    document.getElementById("title").readOnly = false;
    document.getElementById("telephonenumber").readOnly = false;
    document.getElementById("telephoneassistant").readOnly = false;
    document.getElementById("mobile").readOnly = false;
    document.getElementById("physicaldeliveryofficename").readOnly = false;
    document.getElementById("description").readOnly = false;
    document.getElementById("modify").style.visibility = 'hidden';
    document.getElementById("submitedit").style.visibility = 'visible';
};

