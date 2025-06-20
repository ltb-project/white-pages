<div class="alert shadow alert-success">{$msg_authenticate|unescape: "html" nofilter}</div>

<div class="row mt-5 pb-3">
<div class="col-md-3"></div>
<div class="col-md-6 card shadow">

  <div class="card-body">

  <form method="post" action="index.php?page=login">

  <div class="mb-3">
    <label for="inputLogin" class="form-label">{$msg_login}</label>
    <div class="input-group">
      <span class="input-group-text"><i class="fa fa-user"></i></span>
      <input type="text" class="form-control" id="inputLogin" name="login" required />
    </div>
  </div>
  <div class="mb-3">
    <label for="inputPassword" class="form-label">{$msg_password}</label>
    <div class="input-group">
      <span class="input-group-text"><i class="fa fa-lock"></i></span>
      <input type="password" class="form-control" id="inputPassword" name="password" required />
    </div>
  </div>

  <input type="hidden" name="return_page" value="{$return_page}" />
  <input type="hidden" name="action" value="login" />

  <div class="text-center">
    <button type="submit" class="btn btn-success" >
      M'identifier
    </button>
  </div>

  </form>

  </div>

</div>
<div class="col-md-3"></div>
</div>
