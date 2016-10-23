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
              <a class="navbar-brand" href="index.php"><i class="fa fa-home"></i> {$msg_title}</a>
            </div>
            <div class="navbar-collapse collapse">
              <form class="navbar-form navbar-right" role="search" action="index.php?page=search" method="post">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="{$msg_search}" name="search" />
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">&nbsp;<i class="fa fa-search"></i></button>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>

    </div>
