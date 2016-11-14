    <div class="navbar-wrapper">

        <div class="navbar navbar-default navbar-static-top" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><i class="fa fa-fw fa-home"></i> {$msg_title}</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                {if $use_advanced_search}
                <li {if $page=="advancedsearch"}class="active"{/if}>
                  <a href="index.php?page=advancedsearch"><i class="fa fa-fw fa-search-plus"></i> {$msg_advancedsearch}</a>
                </li>
                {/if}
                {if $use_gallery}
                <li {if $page=="gallery"}class="active"{/if}>
                  <a href="index.php?page=gallery"><i class="fa fa-fw fa-th"></i> {$msg_gallery}</a>
                </li>
                {/if}
              </ul>
              {if $use_quick_search}
              <form class="navbar-form navbar-right" role="search" action="index.php?page=search" method="post">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="{$msg_search}" name="search" value="{$search}" />
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">&nbsp;<i class="fa fa-fw fa-search"></i></button>
                  </span>
                </div>
              </form>
              {/if}
            </div>
          </div>
        </div>

    </div>
