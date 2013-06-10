
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>Codeigniter With JQGrid</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>jqGrid/css/redmond/jquery-ui-1.10.3.custom.css" />
    <link type="text/css" href="<?php echo base_url()?>jqGrid/css/ui.jqgrid.css" rel="stylesheet" />
  
    <script type="text/javascript" src="<?php echo base_url(); ?>jqGrid/js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqGrid/js/i18n/grid.locale-en.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>jqGrid/js/jquery.jqGrid.min.js"></script>
    
    <style type="text/css">

    </style>
</head>

<body>
    
        <h1>Patients</h1>
    <?php
        $ci =& get_instance();
        $base_url = base_url();
    ?>
    <table id="patients"></table><!--Grid table-->
    <div id="pager"></div>  <!--pagination div-->
  
</body>


<script type="text/javascript">
        $(document).ready(function (){
            jQuery("#patients").jqGrid({
                url:'<?=$base_url.'index.php/patients/patientsData'?>',      //another controller function for generating data
                mtype : "post",             //Ajax request type. It also could be GET
                datatype: "json",            //supported formats XML, JSON or Arrray
                colNames:['first_name','last_name'],       //Grid column headings
                colModel:[
                    {name:'first_name',index:'first_name', editable: true, required: true},
                    {name:'last_name',index:'last_name', editable: true, required: true},
                ],
                rowNum: 20,
                width: 800,
                search:false,
           //     height: '100%',
           //     rowList:[10,20,30],
                pager: '#pager',
                sortname: 'id',
                viewrecords: true,
                rownumbers: true,
                gridview: true,
                editurl: '<?=$base_url.'index.php/patients/oper'?>',
                caption:"Patients"
            }).navGrid('#pager',{edit:true,add:true,del:true,search:false});
        });
</script>
</html>