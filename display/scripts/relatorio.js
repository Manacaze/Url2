
function imprimir_fichamembro_view(){
        VentanaCentrada('pdf/documentos/fichaMembro_vazio.php','Ficha','','1024','768','true');
    }
function imprimir_fichamembro_Preenchido(id){
        VentanaCentrada('pdf/documentos/fichaMembro_Prenchido.php?idd='+id,'Ficha','','1024','768','true');
    }
//################ Pesquisas ######################################################################################################
    function imprimir_pesquisaMembro(){
        
        //Valores dos Inputs
        var email = $("#email").val();
        var tel_fixo = $("#tel_fixo").val();
        var cell = $("#cell").val();
        var local_trabalho = $("#local_trabalho").val();
        var id_membro = $("#nome_membro").val();
        var id_provincia = $("#nome_provincia").val();
        var id_distrito = $("#distrito").val();
        var id_posto = $("#posto_administrativo").val();  
        var id_tipo_doc = $("#tipo_doc").val();
        var nr_doc = $("#nr_doc").val();
        var nr_cartao_membro = $("#nr_cartao_membro").val();
        var nr_cartao_eleitor = $("#nr_cartao_eleitor").val();
        var id_estado_civil = $("#id_estado_civil").val();
        var id_sexo = $("#id_sexo").val();
        var id_provincia_militancia = $("#nome_provincia_militancia").val();
        var id_distrito_militancia = $("#distrito_militancia").val();
        var id_zona_militancia = $("#zona_militancia").val();
        var id_circulo_militancia = $("#circulo_militancia").val();
        var id_celula_militancia = $("#celula_militancia").val();
        var id_pais_militancia = $("#pais_militancia").val();
        var id_profissao =$("#profissao").val();
        var id_ocupacao = $("#ocupacao").val();
        var id_nome_provincia_residencia = $("#nome_provincia_residencia").val();
        var id_distrito_residencia = $("#distrito_residencia").val();
        var id_posto_administrativo_residencia = $("#posto_administrativo_residencia").val();
        var id_funcao_partido = $("#funcao_partido").val();
        var id_orgao_partido = $("#orgao_partido").val();
        var id_ACLLN = $("#ACLLN").val();
        var id_OMM = $("#OMM").val();
        var id_OJM = $("#OJM").val();
        var id_inativo = $("#inativo").val();
        var caminho = "id_membro="+id_membro+"&id_provincia="+id_provincia+"&id_distrito="+id_distrito+"&id_posto="+id_posto+"&id_tipo_doc="+id_tipo_doc+"&nr_doc="+nr_doc+"&nr_cartao_membro="+nr_cartao_membro+"&nr_cartao_eleitor="+nr_cartao_eleitor+"&id_estado_civil="+id_estado_civil+"&id_sexo="+id_sexo+"&id_provincia_militancia="+id_provincia_militancia+"&id_distrito_militancia="+id_distrito_militancia+"&id_zona_militancia="+id_zona_militancia+"&id_circulo_militancia="+id_circulo_militancia+"&id_celula_militancia="+id_celula_militancia+"&id_pais_militancia="+id_pais_militancia+"&id_profissao="+id_profissao+"&id_ocupacao="+id_ocupacao+"&id_nome_provincia_residencia="+id_nome_provincia_residencia+"&id_distrito_residencia="+id_distrito_residencia+"&id_posto_administrativo_residencia="+id_posto_administrativo_residencia+"&id_funcao_partido="+id_funcao_partido+"&id_orgao_partido="+id_orgao_partido+"&id_ACLLN="+id_ACLLN+"&id_OMM="+id_OMM+"&id_OJM="+id_OJM+"&id_inativo="+id_inativo+"&email="+email+"&tel_fixo="+tel_fixo+"&cell="+cell+"&local_trabalho="+local_trabalho;

        VentanaCentrada('pdf/documentos/resultado_pesquisaMembro.php?'+caminho,'Ficha','','1024','768','true');
    }
//###################################### Pesquisas Fim ############################################################################
/*  
    function imprimir_detEntrevista(){
        var inqId = document.getElementById("inqId").value;
        var respEntrevistaId = document.getElementById("respEntrevistaId").value;
        VentanaCentrada('../pdf/documentos/detEntrevista.php?inqId='+inqId+'&id='+respEntrevistaId ,'Entrevista','','1024','768','true');
    }*/