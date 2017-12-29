<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_frl_cadstro_de_profissoes", $Language->MenuPhrase("1", "MenuText"), "frl_cadstro_de_profissoeslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mi_frl_celula", $Language->MenuPhrase("2", "MenuText"), "frl_celulalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mi_frl_circulo", $Language->MenuPhrase("3", "MenuText"), "frl_circulolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mi_frl_estado_civil", $Language->MenuPhrase("4", "MenuText"), "frl_estado_civillist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mi_frl_formacaoacademica", $Language->MenuPhrase("5", "MenuText"), "frl_formacaoacademicalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mi_frl_funcoes_membro", $Language->MenuPhrase("7", "MenuText"), "frl_funcoes_membrolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mi_frl_paises", $Language->MenuPhrase("8", "MenuText"), "frl_paiseslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mi_frl_razoes_de_inactivo", $Language->MenuPhrase("9", "MenuText"), "frl_razoes_de_inactivolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mi_frl_sexo", $Language->MenuPhrase("10", "MenuText"), "frl_sexolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(11, "mi_frl_tipo_de_documento_de_ident", $Language->MenuPhrase("11", "MenuText"), "frl_tipo_de_documento_de_identlist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mi_frl_tipo_usuario", $Language->MenuPhrase("12", "MenuText"), "frl_tipo_usuariolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mi_frl_usuario", $Language->MenuPhrase("13", "MenuText"), "frl_usuariolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mi_frl_zona", $Language->MenuPhrase("14", "MenuText"), "frl_zonalist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mi_sms_distritos", $Language->MenuPhrase("15", "MenuText"), "sms_distritoslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(16, "mi_sms_postos_administrativos", $Language->MenuPhrase("16", "MenuText"), "sms_postos_administrativoslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(17, "mi_sms_provincias", $Language->MenuPhrase("17", "MenuText"), "sms_provinciaslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(18, "mi_frl_cadastro_de_orgaos", $Language->MenuPhrase("18", "MenuText"), "frl_cadastro_de_orgaoslist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(20, "mi_frl_cadastro_de_ocupacao_profi", $Language->MenuPhrase("20", "MenuText"), "frl_cadastro_de_ocupacao_profilist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->AddMenuItem(25, "mi_frl_usuario_estado", $Language->MenuPhrase("25", "MenuText"), "frl_usuario_estadolist.php", -1, "", TRUE, FALSE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
