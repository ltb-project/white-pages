
<div class="row">
    <div class="col-md-2"></div>
        <div class="display col-md-8">

            <div class="panel panel-info">

                <div class="panel-heading text-center">
                    <p class="panel-title">
                        <i class="fa fa-fw fa-key"></i>
                        
                        Authentification

                    </p>
                </div>

                <div class="panel-body">

                    
                    <img src="photo.php?dn={$userDN|escape:'url'}" alt="{$entry.{$attributes_map.{$card_title}.attribute}.0}" class="img-responsive img-thumbnail center-block" />
                    
                    {if {$err_ldap}}
                        <div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> Erreur de connexion.</div>
                    {/if}
                    {if {$err_log}}
                        <div class="alert alert-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> Identifiant ou mot de passe incorrect.</div>
                    {/if}



                    <form role="login" action="index.php?page=login&dn={$userDN}" method="post">

                        <div class="form-group row">
                            <label for="identifiant" class="col-sm-offset-2 col-sm-3 control-label">Identifiant</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-id-badge"></i></span>
                                    <input type="text" class="form-control" name="identifiant" placeholder="Identifiant" value="{$username}" required>
                                </div>
                            </div>
                        </div>
                
                        <div class="form-group row"  >
                            <label for="password" class="col-sm-offset-2 col-sm-3 control-label">Mot de passe</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="" required>
                                </div>
                            </div>
                        </div>
                    
                        
                        <div class="col-sm-offset-4 col-sm-6">
                            <button class="btn btn-success " type="submit" name="submit" role="button"><i class="fa fa-fw fa-check"></i> Valider</button>
                        </div>
                        
                     
              
                    </form>

                </div>
            </div>
        </div>
</div>

