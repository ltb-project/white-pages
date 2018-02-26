</div>

<script src="vendor/jquery/js/jquery-1.10.2.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-datepicker/locales/bootstrap-datepicker.{$lang}.min.js"></script>

{if $use_datatables}
{literal}
    <script src="vendor/datatables/datatables.min.js"></script>
    <script type="text/javascript">
      $(document).ready( function() {
        var itemlist = $('table.dataTable').DataTable({
          "stateSave":    true,
          "searching":    true,
          "paging":       true,
          "info":         true,
          "processing":   true,
{/literal}
{if $datatables_page_length_choices}
          "lengthMenu": [
              [ {$datatables_page_length_choices} ],
              [ {$datatables_page_length_choices|replace:'-1':($msg_pager_all|string_format:'"%s"') } ]
          ],
{/if}
{if $datatables_page_length_default}
          "pageLength": {$datatables_page_length_default},
{/if}
{literal}
          "dom":
            "<'row ft-head'<'col-sm-6'l><'col-sm-6'<'pull-right'B>f>>" +
            "<'row dt-main'<'col-sm-12'tr>>" +
            "<'row dt-foot'<'col-sm-6'i><'col-sm-6'p>>",
          "buttons": [
            { extend: 'print', autoPrint: true,                                              text: "{/literal}{$msg_print_all}{literal}" },
            { extend: 'print', autoPrint: true, exportOptions: {modifier:{page: 'current'}}, text: "{/literal}{$msg_print_page}{literal}" },
          ],

          "order": [
            [ {/literal}{$listing_sortby|default:0 + 1}{literal}, "asc" ]
          ],
          "aoColumnDefs": [
            { "bSortable": false, "aTargets": ['nosort'] },
          ],
          "language": {
            "url": "vendor/datatables/i18n/{/literal}{$lang|default:'en'}{literal}.json"
          }
        });
      });
    </script>
{/literal}
{/if}

</body>
</html>
