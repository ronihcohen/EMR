
    

        <h2>Users</h2>


        
    <?php
        $ci =& get_instance();
        $base_url = base_url();
    ?>


    <table id="users"></table><!--Grid table-->
    <div id="users_pager"></div>  <!--pagination div-->
   



<script type="text/javascript">
        $(document).ready(function (){
            jQuery("#users").jqGrid({
                url:'<?=$base_url.'index.php/admin/usersData'?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['username','group_id'],       //Grid column headings
                colModel:[
                    {name:'username',index:'username', editable: true, required: true},
                    {name:'group_id',index:'group_id', editable: true, required: true},
                ],
                rowNum: 20,
                width: 800,
                height: '100%',
                search:false,
                scrollOffset: 0,
                rowList:[10,20,30],
                pager: '#users_pager',
                sortname: 'id',
                viewrecords: true,
                rownumbers: false,
                gridview: true,
                editurl: '<?=$base_url.'index.php/admin/oper'?>',
                caption:"Users",
                subGrid: true,



            }).navGrid('#users_pager',{edit:true,add:false,del:true});
        });
</script>

    
