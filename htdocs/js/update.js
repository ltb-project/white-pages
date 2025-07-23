$(document).ready(function(){
  let timer;

  $(".dn_link_container input[type=text]").on("keyup", function (event) {
    // Remove value if field is emptied or less than minimal characters
    if ($(this).val().length <= 2) {
        $(this).siblings('input[type=hidden]').val('') ;
        $(this).siblings('div.dn_link_suggestions').empty();
    }
    // Minimal search characters
    if ($(this).val().length > 2) {
      if (timer) {
        clearTimeout(timer);
        $(this).siblings('div.dn_link_suggestions').empty();
      }

      timer = setTimeout(() => {
        $.post("index.php", { 'apiendpoint': 'search_dn', 'search': $(this).val(), 'search_type': 'dn_link' }, (data) => {
          // clear existing list
          $(this).siblings('div.dn_link_suggestions').empty();
          if (data.entries) {
            // add entries to list
            data.entries.forEach( (entry) => {
              const $elem = $(`<button type="button" class="list-group-item list-group-item-action">${entry.display}</button>`);
              $elem.on('click', () => {
                $(this).val(entry.display);
                $(this).siblings('input[type=hidden]').val(entry.dn);
                $(this).siblings('div.dn_link_suggestions').empty();
              })
              $(this).siblings('div.dn_link_suggestions').append($elem);
            });
            if (data.warning) {
              const $elem = $(`<span class="list-group-item list-group-item-warning">${data.warning}</span>`);
              $(this).siblings('div.dn_link_suggestions').append($elem);
            }
          }
          if (data.error) {
            const $elem = $(`<span class="list-group-item list-group-item-danger">${data.error}</span>`);
            $(this).siblings('div.dn_link_suggestions').append($elem);
          }
        }, 'json');
      }, 500);
    }
  });

  function delValueEditor(event) {
      $(this).closest('.value_editor_container').remove();
  }

  $('button[data-action=add]').on("click", function (event) {
      var item = $(this).attr('data-item');
      var length = $(this).closest('.value_editor_container').siblings('.value_editor_container').length;
      var newindex = length + 1;
      var clone = $(this).closest('.value_editor_container').clone(true);
      clone.find('.value_editor_field *[data-role=display]').val('');
      clone.find('.value_editor_field *[data-role=value]').val('');
      clone.find('.value_editor_field *[data-role=value]').attr('name', item + '' + newindex);
      clone.find('.value_editor_button button').removeClass('btn-success').addClass('btn-danger');
      clone.find('.value_editor_button button').attr('data-action','del');
      clone.find('.value_editor_button button').attr('data-index', newindex);
      clone.find('.value_editor_button button').off("click");
      clone.find('.value_editor_button button').on("click", delValueEditor);
      clone.find('.value_editor_button button span').removeClass('fa-plus').addClass('fa-minus');
      $(this).closest('.value_editor_container').parent().append(clone);
  });

  $('button[data-action=del]').on("click", delValueEditor);

});
