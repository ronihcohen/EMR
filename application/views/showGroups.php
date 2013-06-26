
    

        <h2>Groups and permissions</h2>
        <p>


    <?php
        $ci =& get_instance();
        $base_url = base_url();
    ?>


    <table id="groups"></table><!--Grid table-->
    <div id="groups_pager"></div>  <!--pagination div-->
   



<script type="text/javascript">
        $(document).ready(function (){
            jQuery("#groups").jqGrid({
                url:'<?=$base_url.'index.php/admin/groupsData'?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['ID','Name'],       //Grid column headings
                colModel:[
                    {name:'group_name',index:'group_name', editable: false, required: false},
                    {name:'group_id',index:'group_id', editable: true, required: true},
             
                ],
                rowNum: 20,
                width: 800,
                height: '100%',
                search:false,
                scrollOffset: 0,
                rowList:[10,20,30],
                pager: '#groups_pager',
                sortname: 'id',
                viewrecords: true,
                rownumbers: false,
                gridview: true,
                editurl: '<?=$base_url.'index.php/admin/groupOper'?>',
                caption:"Groups",
                subGrid: true,

                subGridRowExpanded: function(subgrid_id, row_id) {
                    var subgrid_table_id, pager_id;
                    subgrid_table_id = subgrid_id+"_t";
                    pager_id = "p_"+subgrid_table_id;
                    $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><a href='<?=$base_url.'index.php/admin/groups/addpermission/'?>"+row_id+"'>Add Permissions</a>");
                    jQuery("#"+subgrid_table_id).jqGrid({
                        url:'<?=$base_url.'index.php/admin/permissionsData/group/'?>'+row_id,
                        datatype: "json",
                        mtype : "post",
                            colNames:['Permissions Name'],       //Grid column headings
                            colModel:[
                                {name:'name',index:'name', editable: false, required: false},
                               
                            ],
                        sortname: 'num',
                        sortorder: "asc",
                        height: '100%'
                    });
                },

            }).navGrid('#group_pager',{edit:true,add:false,del:true});
        });
</script>




<?php
if (isset($group_id) and $group_id!='') {
?>

    <script type="text/javascript">
        $(document).ready(function (){
            jQuery("#permissions").jqGrid({
                url:'<?=$base_url.'index.php/admin/permissionsData/all'?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['Permission Name'],       //Grid column headings
                colModel:[
                    {name:'name',index:'name', editable: false, required: false},
             
                ],
                rowNum: 20,
                width: 800,
                height: '100%',
                search:false,
                scrollOffset: 0,
                rowList:[10,20,30],
                pager: '#permissions_pager',
                sortname: 'id',
                viewrecords: true,
                rownumbers: false,
                gridview: true,
                caption:"Select Permission adding to group <?=$group_id?>",
                 onSelectRow: function(id){ 
                    window.location.replace ('<?=$base_url.'index.php/admin/groups/addpermission/'?><?=$group_id?>/'+id);
                 },
            }).navGrid('#permissions_pager',{edit:false,add:false,del:false});
        });
    </script>

    <br/> <br/>

    <table id="permissions"></table><!--Grid table-->
    <div id="permissions_pager"></div>  <!--pagination div-->

<?php
}
?>


    
