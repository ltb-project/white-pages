</div>

<script src="vendor/jquery/js/jquery-1.10.2.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-datepicker/locales/bootstrap-datepicker.{$lang}.min.js"></script>

{if $use_directory}
{literal}
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready( function() {
        var itemlist = $('#directory-listing').DataTable({
          "stateSave":    true,
          "searching":    true,
          "paging":       true,
          "info":         true,
          "processing":   true,
          "pageLength":   {/literal}{$default_page_length|default:10}{literal},
          "lengthMenu": [
            [10, 25, 50, 100, -1], [10, 25, 50, 100, "{/literal}{$msg_pager_all}{literal}"]
          ],
          "order": [
            [ {/literal}{$sortby|default:0 + 1}{literal}, "asc" ]
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
