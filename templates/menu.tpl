    <div class="mb-3">

        <nav class="navbar navbar-expand-lg bg-body-tertiary" role="navigation">
          <div class="container-fluid">
              <a class="navbar-brand" href="index.php?page=welcome">
                {if $logo}
                <img src="{$logo}" alt="Logo" class="menu-logo img-fluid" />
                {/if}
                {$msg_title}
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">

              {if ($require_auth and $userdn) or !$require_auth}
              <ul class="nav navbar-nav me-auto mb-2 mb-lg-0">

                {if $use_advanced_search}
                <li class="nav-item">
                  <a class="nav-link{if $page=="advancedsearch"} active{/if}" href="index.php?page=advancedsearch"><i class="fa fa-fw fa-search-plus"></i> {$msg_advancedsearch}</a>
                </li>
                {/if}
                {if $use_directory}
                <li class="nav-item">
                  <a class="nav-link{if $page=="directory"} active{/if}" href="index.php?page=directory"><i class="fa fa-fw fa-th-list"></i> {$msg_directory}</a>
                </li>
                {/if}
                {if $use_gallery}
                <li class="nav-item">
                  <a class="nav-link{if $page=="gallery"} active{/if}" href="index.php?page=gallery"><i class="fa fa-fw fa-user-circle"></i> {$msg_gallery}</a>
                </li>
                {/if}
                {if $use_map}
                <li class="nav-item">
                  <a class="nav-link{if $page=="map"} active{/if}"  href="index.php?page=map"><i class="fa fa-fw fa-globe"></i> {$msg_map}</a>
                </li>
                {/if}
                {if (!$require_auth and $logout_link) or ($require_auth and $userdn)}
                <li class="nav-item">
                  <a class="nav-link" href="{if $require_auth}index.php?page=logout{else}{$logout_link}{/if}"><i class="fa fa-fw fa-sign-out"></i> {$msg_logout}</a>
                </li>
                {/if}
              </ul>
              {if $use_quick_search}
              <form class="d-flex" role="search" action="index.php?page=search" method="post">
                <div class="input-group">
                  <input type="text" class="form-control border-secondary" placeholder="{$msg_search}" name="search" value="{$search}" />
                  <button class="btn btn-default btn-outline-secondary" type="submit">&nbsp;<i class="fa fa-fw fa-search"></i></button>
                </div>
              </form>
              {/if}

              {/if}
            </div>
          </div>
        </nav>

    </div>
