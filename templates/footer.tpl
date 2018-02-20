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
          "order": [
            [ {/literal}{$sortby + 1}{literal}, "asc" ]
          ],
          "aoColumnDefs": [
            { "bSortable": false, "aTargets": ['nosort'] },
          ],
          "language": {
            "url": "vendor/datatables/i18n/{/literal}{$lang}{literal}.json"
          }
        });
      });
    </script>
{/literal}
{/if}

</body>
</html>
