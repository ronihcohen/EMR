<head>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>jqGrid/css/ui-lightness/jquery-ui-1.10.3.custom.css" />

    <link type="text/css" href="<?php echo base_url()?>jqGrid/css/ui.jqgrid.css" rel="stylesheet" />

    <link type="text/css" href="<?php echo base_url()?>jqGrid/css/plugins/searchFilter.css" rel="stylesheet" />

    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 75%;
        }
    </style>

    <script type="text/javascript" src="<?php echo base_url(); ?>jqGrid/js/jquery-1.9.0.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>jqGrid/js/i18n/grid.locale-en.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>jqGrid/js/jquery.jqGrid.min.js"></script>


    <title>Codeigniter With JQGrid</title>
</head>
<body>
    <center>
        <h1>Codeigniter With JQGrid</h1>
    <?php
        $ci =& get_instance();
        $base_url = base_url();
    ?>
    <table id="list"></table><!--Grid table-->
    <div id="pager"></div>  <!--pagination div-->
    </center>
</body>


<script type="text/javascript">
        $(document).ready(function (){
            jQuery("#list").jqGrid({
                url:'<?=$base_url.'index.php/diagnosis/loadData'?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['id','english_name'],       //Grid column headings
                colModel:[
                    {name:'id',index:'id', width:100, align:"left"},
                    {name:'english_name',index:'english_name', width:150, align:"left"},
                ],
                rowNum:10,
                width: 750,
                //height: 300,
                rowList:[10,20,30],
                pager: '#pager',
                sortname: 'id',
                viewrecords: true,
                rownumbers: true,
                gridview: true,
                caption:"List Of Person"
            }).navGrid('#pager',{edit:false,add:false,del:false});
        });
</script>