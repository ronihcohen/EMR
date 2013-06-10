
    

        <h2>Patients with Diagnosis</h2>


        
    <?php
        $ci =& get_instance();
        $base_url = base_url();
    ?>


    <table id="patients"></table><!--Grid table-->
    <div id="patients_pager"></div>  <!--pagination div-->
   



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
                height: '100%',
                search:false,
                scrollOffset: 0,
                rowList:[10,20,30],
                pager: '#patients_pager',
                sortname: 'id',
                viewrecords: true,
                rownumbers: false,
                gridview: true,
                editurl: '<?=$base_url.'index.php/patients/oper'?>',
                caption:"Patients",
                subGrid: true,

                subGridRowExpanded: function(subgrid_id, row_id) {
                    var subgrid_table_id, pager_id;
                    subgrid_table_id = subgrid_id+"_t";
                    pager_id = "p_"+subgrid_table_id;
                    $("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><a href='<?=$base_url.'index.php/diagnosis/DiagnosisToPatient/'?>"+row_id+"'>Add diagnosis</a>");
                    jQuery("#"+subgrid_table_id).jqGrid({
                        url:'<?=$base_url.'index.php/patients/diagnosisData/'?>'+row_id,
                        datatype: "json",
                        mtype : "post",
                            colNames:['hebrew_name','english_name','date'],       //Grid column headings
                            colModel:[
                                {name:'hebrew_name',index:'hebrew_name', editable: false, required: false},
                                {name:'english_name',index:'english_name', editable: false, required: false},
                                {name:'date',index:'date', editable: false, required: false},
                            ],
                        sortname: 'num',
                        sortorder: "asc",
                        height: '100%'
                    });
                },


            }).navGrid('#patients_pager',{edit:true,add:true,del:true});
        });
</script>

    
