$(document).ready(function(){
    $("#dataNascimento").mouseout(function(){
    // Return today's date and time
        var currentTime = new Date();
        // returns the year (four digits)
        var year = currentTime.getFullYear();

        var myString = document.getElementById("dataNascimento").value; //xml nodeValue from time element
        var array = new Array();

        //split string and store it into array
        array = myString.split('/');

        //from array concatenate into new date string format: "DD.MM.YYYY"
        var dataNascimento = (array[2]);
        var idade = year - dataNascimento;
        //Idade
        document.getElementById("idadeMembro").value = idade;
    })
//######################################################################
    
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
	$(".select2").select2();
    
    $("#provincia2").change(function(){
        
        var id = $(this).val();
        var string = "id="+id;
        
        $.ajax({
            type: "POST",
            url: "include/select/getDistrito.php",
            data: string,
            cache: false,
            success: function(html){
                $("#distrito").html(html);
                $("#zona").html("<option value=''>Selecione o Distrito</option>");
                $("#circulo").html("<option value=''>Selecione o Distrito</option>");
                $("#celula").html("<option value=''>Selecione o Distrito</option>");
            }
        });
    });
    $("#distrito").change(function(){
       
        var id = $(this).val();
        var string = "id="+id;
        $.ajax
        ({
            type: "POST",
            url: "include/select/getZona.php",
            data: string,
            cache: false,
            success: function(html){
                $("#zona").html(html);
                $("#circulo").html("<option value=''>Selecione a Zona</option>");
                $("#celula").html("<option value=''>Selecione a Zona</option>");
            }
        });
    });
    $("#zona").change(function(){
        
        var id= $(this).val();
        var string = "id="+id;
        
        $.ajax({
            type: "POST",
            url: "include/select/getCirculo.php",
            data: string,
            cache: false,
            success: function(html){
                $("#circulo").html(html);
                $("#celula").html("<option value=''>Selecione o Circulo</option>");
            }
        });
    });
    $("#circulo").change(function(){
        
        var id= $(this).val();
        var string = "id="+id;
        
        $.ajax({
            type: "POST",
            url: "include/select/getCelula.php",
            data: string,
            cache: false,
            success: function(html){
                $("#celula").html(html);
            }
        });
    });
    


    //Pesquisa Nascimento Membro\
    $("#provinciaNascimento").change(function(){
        
        var id = $(this).val();
        var string = "id="+id;
        $.ajax({
            type: "POST",
            url: "include/select/getDistrito.php",
            data: string,
            cache: false,
            success: function(html){
                $("#distritoNascimento").html(html);
                $("#postoAdminNascimento").html("<option value=''>Selecione o Distrito</option>");
            }
        });
    });
    $("#distritoNascimento").change(function(){
        
        var id = $(this).val();
        var string = "id="+id;
        $.ajax({
            type: "POST",
            url: "include/select/getPostoAdmin.php",
            data: string,
            cache: false,
            success: function(html){
                $("#postoAdminNascimento").html(html);
            }
        });
    });
    //Residencia
        $("#provinciaResidencia").change(function(){
        
        var id = $(this).val();
        var string = "id="+id;
        $.ajax({
            type: "POST",
            url: "include/select/getDistrito.php",
            data: string,
            cache: false,
            success: function(html){
                $("#distritoResidencia").html(html);
                $("#postoAdminResidencia").html("<option value=''>Selecione o Distrito</option>");
            }
        });
    });
    $("#distritoResidencia").change(function(){
        
        var id = $(this).val();
        var string = "id="+id;
        $.ajax({
            type: "POST",
            url: "include/select/getPostoAdmin.php",
            data: string,
            cache: false,
            success: function(html){
                $("#postoAdminResidencia").html(html);
            }
        });
    });
    
    ////Verivicacao do Formulario e criacao do Codigo do membro/////////////
    $("#btnCartaoMembroNr").click(function(){
        
        $.ajax({
            type: "POST",
            url: "include/formulario/setMemberNumber.php",
            data: "",
            cache: false,
            success: function(html){
                $("#setNumber").html(html);
            }
        })                              
    });
    
    $("#inactivo_0").click(function(){
        if($('input[id="inactivo_0"]').prop('checked')==true){
           $('#razoesInactivo').prop('disabled', false);
        }
        else{
           $('#razoesInactivo').prop('disabled', true);
        }
    })


    
   ////////##########################################//////Pesquisa/////############################################
    /*pesquisa de membros*/

    $(".pesquisa").change(function(){
        var todos = $("#todosMembros").prop('checked');
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
        var caminho = "id_membro="+id_membro+"&id_provincia="+id_provincia+"&id_distrito="+id_distrito+"&id_posto="+id_posto+"&id_tipo_doc="+id_tipo_doc+"&nr_doc="+nr_doc+"&nr_cartao_membro="+nr_cartao_membro+"&nr_cartao_eleitor="+nr_cartao_eleitor+"&id_estado_civil="+id_estado_civil+"&id_sexo="+id_sexo+"&id_provincia_militancia="+id_provincia_militancia+"&id_distrito_militancia="+id_distrito_militancia+"&id_zona_militancia="+id_zona_militancia+"&id_circulo_militancia="+id_circulo_militancia+"&id_celula_militancia="+id_celula_militancia+"&id_pais_militancia="+id_pais_militancia+"&id_profissao="+id_profissao+"&id_ocupacao="+id_ocupacao+"&id_nome_provincia_residencia="+id_nome_provincia_residencia+"&id_distrito_residencia="+id_distrito_residencia+"&id_posto_administrativo_residencia="+id_posto_administrativo_residencia+"&id_funcao_partido="+id_funcao_partido+"&id_orgao_partido="+id_orgao_partido+"&id_ACLLN="+id_ACLLN+"&id_OMM="+id_OMM+"&id_OJM="+id_OJM+"&id_inativo="+id_inativo+"&email="+email+"&tel_fixo="+tel_fixo+"&cell="+cell+"&local_trabalho="+local_trabalho+"&todos="+todos;
        //alert(caminho);
        if(todos.toString() == 'false' && email=="" && tel_fixo=="" && cell=="" && local_trabalho=="" && id_membro=="0" && id_provincia=="0" && id_distrito=="0"
        && id_posto=="0" && id_tipo_doc=="0" && nr_doc=="0" && nr_cartao_membro=="0" && nr_cartao_eleitor=="0" && id_estado_civil=="0" && id_sexo=="0"
        && id_provincia_militancia=="0" && id_distrito_militancia=="0" && id_zona_militancia=="0" && id_circulo_militancia=="0" && id_circulo_militancia=="0"
        && id_celula_militancia=="0" && id_pais_militancia=="0" && id_profissao=="0" && id_ocupacao=="0" && id_nome_provincia_residencia=="0" && id_distrito_residencia=="0"
        && id_posto_administrativo_residencia=="0" && id_funcao_partido=="0" && id_orgao_partido=="0" && id_ACLLN==2 && id_OMM==2 && id_OJM==2 && id_inativo==2) {
            $("#Pesquisa_tabela_corpo").html("<tr><td colspan='8' align='center'>Selecione o Mecanismo de pesquisa</td></tr>");
        }
        else {
            $.ajax({
                type: "POST",
                url: "include/pesquisaMembro/accoesListagem.php",
                data: caminho,
                cache: false,
                success: function (html) {
                    $("#Pesquisa_tabela_corpo").html(html);
                }

            })
        }
    });


    $(".pesquisa_like").keyup(function(){

        var todos = $("#todosMembros").prop('checked');
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
        var caminho = "id_membro="+id_membro+"&id_provincia="+id_provincia+"&id_distrito="+id_distrito+"&id_posto="+id_posto+"&id_tipo_doc="+id_tipo_doc+"&nr_doc="+nr_doc+"&nr_cartao_membro="+nr_cartao_membro+"&nr_cartao_eleitor="+nr_cartao_eleitor+"&id_estado_civil="+id_estado_civil+"&id_sexo="+id_sexo+"&id_provincia_militancia="+id_provincia_militancia+"&id_distrito_militancia="+id_distrito_militancia+"&id_zona_militancia="+id_zona_militancia+"&id_circulo_militancia="+id_circulo_militancia+"&id_celula_militancia="+id_celula_militancia+"&id_pais_militancia="+id_pais_militancia+"&id_profissao="+id_profissao+"&id_ocupacao="+id_ocupacao+"&id_nome_provincia_residencia="+id_nome_provincia_residencia+"&id_distrito_residencia="+id_distrito_residencia+"&id_posto_administrativo_residencia="+id_posto_administrativo_residencia+"&id_funcao_partido="+id_funcao_partido+"&id_orgao_partido="+id_orgao_partido+"&id_ACLLN="+id_ACLLN+"&id_OMM="+id_OMM+"&id_OJM="+id_OJM+"&id_inativo="+id_inativo+"&email="+email+"&tel_fixo="+tel_fixo+"&cell="+cell+"&local_trabalho="+local_trabalho+"&todos="+todos;

        if(todos.toString() == 'false' && email=="" && tel_fixo=="" && cell=="" && local_trabalho=="" && id_membro=="0" && id_provincia=="0" && id_distrito=="0"
            && id_posto=="0" && id_tipo_doc=="0" && nr_doc=="0" && nr_cartao_membro=="0" && nr_cartao_eleitor=="0" && id_estado_civil=="0" && id_sexo=="0"
            && id_provincia_militancia=="0" && id_distrito_militancia=="0" && id_zona_militancia=="0" && id_circulo_militancia=="0" && id_circulo_militancia=="0"
            && id_celula_militancia=="0" && id_pais_militancia=="0" && id_profissao=="0" && id_ocupacao=="0" && id_nome_provincia_residencia=="0" && id_distrito_residencia=="0"
            && id_posto_administrativo_residencia=="0" && id_funcao_partido=="0" && id_orgao_partido=="0" && id_ACLLN==2 && id_OMM==2 && id_OJM==2 && id_inativo==2) {
            $("#Pesquisa_tabela_corpo").html("<tr><td colspan='8' align='center'>Selecione o Mecanismo de pesquisa</td></tr>");
        }
        else {
            $.ajax({
                type: "POST",
                url: "include/pesquisaMembro/accoesListagem.php",
                data: caminho,
                cache: false,
                success: function (html) {
                    $("#Pesquisa_tabela_corpo").html(html);
                }

            })
        }
    });


	$("#nome_provincia").change(function(){
		var id_provincia = $(this).val();
		var caminho = "id_provincia="+id_provincia;

		$.ajax({
			type: "POST",
			url: "include/pesquisaMembro/pesquisaMembroSelect.php",
			data: caminho,
			cache: false,
			success: function(html){
				$("#distrito").html(html);
				$("#posto_administrativo").html("");
			}
		});
	});


	$("#distrito").change(function(){
		var id_distrito = $(this).val();
		var caminho = "id_distrito="+id_distrito;
		$.ajax({
			type: "POST",
			url: "include/pesquisaMembro/pesquisaMembroSelect.php",
			data: caminho,
			cache: false,
			success: function(html){
				$("#posto_administrativo").html(html);
			}
		})
	});



   $("#nome_membro").change(function(){
        var id_membro = $(this).val();
        var caminho = "id_membro="+id_membro;

        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                $("#tipo_doc").html(html);
            }
        })


   });

   $("#tipo_doc").change(function(){

        var id_tipo_doc = $(this).val();

        var caminho = "id_tipo_doc="+id_tipo_doc;

        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                $("#nr_doc").html(html)
            }
        });

   });

    $("#nome_provincia_militancia").change(function(){
        var id_provincia = $(this).val();
        var nome_onde_estamos_pesquisando = "militancia"; // precisamos saber onde estamos a pesquisar para sabermos se podemos controlar os distritos ou nao. Pk os distritos sem caso de restricoes so sao controlados na militancia
        var caminho = "id_provincia="+id_provincia+"&onde_pesquisamos="+nome_onde_estamos_pesquisando;

        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                $("#distrito_militancia").html(html);
               // $("#posto_administrativo").html("");
              
            }
        });
    });

    $("#distrito_militancia").change(function(){
        var id_distrito_militancia = $(this).val();

        var caminho = "id_distrito_militancia="+id_distrito_militancia;

        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                  $("#zona_militancia").html(html);  

            }

        });
    });

    $("#zona_militancia").change(function(){
        var id_zona_militancia = $(this).val();

        var caminho = "id_zona_militancia="+id_zona_militancia;
        
        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                $("#circulo_militancia").html(html);
            }

        })

    });


    $("#circulo_militancia").change(function(){
        var id_circulo_militancia = $(this).val();

        var caminho = "id_circulo_militancia="+id_circulo_militancia;

        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
             
                $("#celula_militancia").html(html);
            }


        });


    });


      $("#nome_provincia_residencia").change(function(){
        var id_provincia = $(this).val();
        var caminho = "id_provincia="+id_provincia;

        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                $("#distrito_residencia").html(html);
               // $("#posto_administrativo").html("");
            }
        });
    });
     $("#distrito_residencia").change(function(){
        var id_distrito = $(this).val();
        var caminho = "id_distrito="+id_distrito;
        $.ajax({
            type: "POST",
            url: "include/pesquisaMembro/pesquisaMembroSelect.php",
            data: caminho,
            cache: false,
            success: function(html){
                $("#posto_administrativo_residencia").html(html);
            }
        })
    });

//#########################################################################################################################
    //Calculo da idade###################################################
if($("#dataNascimento").val() != '' && "#dataNascimento").val())
{
    // Return today's date and time
    var currentTime = new Date();
    // returns the year (four digits)
    var year = currentTime.getFullYear();
    
    var myString = document.getElementById("dataNascimento").value; //xml nodeValue from time element
    var array = new Array();

    //split string and store it into array
    array = myString.split('/');

    //from array concatenate into new date string format: "DD.MM.YYYY"
    var dataNascimento = (array[2]);
    var idade = year - dataNascimento;
    //Idade
    document.getElementById("idadeMembro").value = idade;
}
    //#########################################################################################################################
});

//Visualizar Fotografia
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#dvPreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#fileupload").change(function(){
    readURL(this);
});
//////#################################### Validacao de Campos ////###################################################
    function numValidacao(){
        this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');
    }
  //////#################################### Validacao de Fim ////###################################################  