
<div class="row">
    <div class="col-md-2 hidden-xs"></div>
        <div class="display col-md-8 col-xs-12">

            <div class="panel panel-info">

                <div class="panel-heading text-center">
                    <p class="panel-title">
                        <i class="fa fa-fw fa-edit"></i>
                        Modification de la fiche
                    </p>
                </div>

                <div class="panel-body">

                    <form role="group" enctype="multipart/form-data" action="index.php?page=editentry" method="post">

                        <img src="photo.php?dn={$distname|escape:'url'}" id="profilepic" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" />
                        {*
                        <div id="drop-region">
                            <div class="drop-message">
                                Drag & Drop images or click to upload
                            </div>
                            <div id="image-preview"></div>
                        </div>  *}

                        <div class="table-responsive">                              {* liste des infos du profil *}
                            <table class="table table-striped table-hover">
                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-camera-retro"></i></th>     {* logo de l'info *}
                                    <th class="hidden-xs"> Photo de profil </th>    {* nom de l'info *}
                                    <td> 
                                        <input type="file" class="form-control" id="thumbnailPhoto" name="thumbnailPhoto" accept="image/jpeg" {$thumbnailPhoto_state} width="180">  {* valeur de l'info *}
                                        <small class="form-text text-muted">Image carrée au format jpeg ou jpg de moins de 100ko. <br> Pour compresser une image, cliquer <a href="https://compressjpeg.com/fr/" target="_blank">ici</a>.</small>
                                    </td>     
                                    
                                </tr>

                                {if {$errProfilePicture ne ''}}
                                    <div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {$errProfilePicture}</div>
                                {/if}
                                
                                
                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-user-o"></i></th> 
                                    <th class="hidden-xs"> Nom </th>   
                                    <td> <input type="text" class="form-control" placeholder="Nom" id="sn" name="sn" value="{$sn}" readonly /> </td>
                                </tr>
                                                                    
                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-user-o"></i></th>
                                    <th class="hidden-xs"> Prénom </th>
                                    <td> <input type="text" class="form-control" placeholder="Prénom" id="givenname" name="givenname" value="{$givenname}" readonly /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-certificate"></i></th>
                                    <th class="hidden-xs"> Titre </th>
                                    <td> <input type="text" class="form-control" placeholder="Titre" id="title" name="title" value="{$title}" {$readonly} /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-envelope"></i></th>
                                    <th class="hidden-xs"> Courriel </th>
                                    <td> <input type="text" class="form-control" placeholder="Adresse mail" id="mail" name="mail" value="{$mail}" readonly /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-phone"></i></th>
                                    <th class="hidden-xs"> Téléphone </th>
                                    <td> <input type="text" class="form-control" placeholder="Téléphone" id="telephoneassistant" name="telephoneassistant" pattern="[0-9]*" maxlength="4" title="Entrer un numéro de téléphone." value="{$telephoneassistant}" {$readonly} /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-phone"></i></th> 
                                    <th class="hidden-xs"> SDA </th>
                                    <td> <input type="text" class="form-control" placeholder="Ligne directe" id="telephonenumber" name="telephonenumber" pattern="[0-9]*" maxlength="10" title="Entrer un numéro de téléphone" value="{$telephonenumber}" {$readonly} /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-mobile"></i></th>
                                    <th class="hidden-xs"> Portable </th>
                                    <td> <input type="text" class="form-control" placeholder="Portable" id="mobile" name="mobile" pattern="[0-9]*" maxlength="10" title="Entrer un numéro de téléphone" value="{$mobile}" {$readonly} /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-building"></i></th>
                                    <th class="hidden-xs"> Bureau </th>
                                    <td> <input type="text" class="form-control" placeholder="Bureau" id="physicaldeliveryofficename" name="physicaldeliveryofficename" value="{$physicaldeliveryofficename}" {$readonly} /> </td>
                                </tr>

                                <tr>
                                    <th class="text-center"><i class="fa fa-fw fa-info-circle"></i></th>
                                    <th class="hidden-xs"> Description </th>
                                    <td> <input type="text" class="form-control" placeholder="Description" id="description" name="description" value="{$description}" {$readonly} /> </td>
                                </tr>

                            </table>
                        </div>
                      

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-3">
                                <button class="btn btn-success" type="submit" id="submitedit" name="submitedit" role="button" style={$submit_state}><i class="fa fa-fw fa-check"></i> Valider</button>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-info" type="button" id="modify" role="button" style={$modify_state}><i class="fa fa-fw fa-edit"></i> Modifier</button>
                            </div>
                            <div class="col-sm-3">
                                <a href="index.php?page=welcome" class="btn btn-warning" role="button"><i class="fa fa-fw fa-sign-out"></i> Quitter</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 hidden-xs"></div>

</div>