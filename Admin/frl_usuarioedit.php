<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "frl_usuarioinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$frl_usuario_edit = NULL; // Initialize page object first

class cfrl_usuario_edit extends cfrl_usuario {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{286C4D49-9D44-49E9-A580-A7321FF88E9C}";

	// Table name
	var $TableName = 'frl_usuario';

	// Page object name
	var $PageObjName = 'frl_usuario_edit';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (frl_usuario)
		if (!isset($GLOBALS["frl_usuario"]) || get_class($GLOBALS["frl_usuario"]) == "cfrl_usuario") {
			$GLOBALS["frl_usuario"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["frl_usuario"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'frl_usuario', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->usuarioId->SetVisibility();
		$this->usuarioId->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nome->SetVisibility();
		$this->UsuarioApelido->SetVisibility();
		$this->usuarioNome->SetVisibility();
		$this->UsuarioEmail->SetVisibility();
		$this->usuarioSenha->SetVisibility();
		$this->usuNivelAcesso->SetVisibility();
		$this->UsuarioSexo->SetVisibility();
		$this->UsuarioEstado->SetVisibility();
		$this->usuarioAvatar->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $frl_usuario;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($frl_usuario);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["usuarioId"] <> "") {
			$this->usuarioId->setQueryStringValue($_GET["usuarioId"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->usuarioId->CurrentValue == "") {
			$this->Page_Terminate("frl_usuariolist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("frl_usuariolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "frl_usuariolist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->usuarioAvatar->Upload->Index = $objForm->Index;
		$this->usuarioAvatar->Upload->UploadFile();
		$this->usuarioAvatar->CurrentValue = $this->usuarioAvatar->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->usuarioId->FldIsDetailKey)
			$this->usuarioId->setFormValue($objForm->GetValue("x_usuarioId"));
		if (!$this->nome->FldIsDetailKey) {
			$this->nome->setFormValue($objForm->GetValue("x_nome"));
		}
		if (!$this->UsuarioApelido->FldIsDetailKey) {
			$this->UsuarioApelido->setFormValue($objForm->GetValue("x_UsuarioApelido"));
		}
		if (!$this->usuarioNome->FldIsDetailKey) {
			$this->usuarioNome->setFormValue($objForm->GetValue("x_usuarioNome"));
		}
		if (!$this->UsuarioEmail->FldIsDetailKey) {
			$this->UsuarioEmail->setFormValue($objForm->GetValue("x_UsuarioEmail"));
		}
		if (!$this->usuarioSenha->FldIsDetailKey) {
			$this->usuarioSenha->setFormValue($objForm->GetValue("x_usuarioSenha"));
		}
		if (!$this->usuNivelAcesso->FldIsDetailKey) {
			$this->usuNivelAcesso->setFormValue($objForm->GetValue("x_usuNivelAcesso"));
		}
		if (!$this->UsuarioSexo->FldIsDetailKey) {
			$this->UsuarioSexo->setFormValue($objForm->GetValue("x_UsuarioSexo"));
		}
		if (!$this->UsuarioEstado->FldIsDetailKey) {
			$this->UsuarioEstado->setFormValue($objForm->GetValue("x_UsuarioEstado"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->usuarioId->CurrentValue = $this->usuarioId->FormValue;
		$this->nome->CurrentValue = $this->nome->FormValue;
		$this->UsuarioApelido->CurrentValue = $this->UsuarioApelido->FormValue;
		$this->usuarioNome->CurrentValue = $this->usuarioNome->FormValue;
		$this->UsuarioEmail->CurrentValue = $this->UsuarioEmail->FormValue;
		$this->usuarioSenha->CurrentValue = $this->usuarioSenha->FormValue;
		$this->usuNivelAcesso->CurrentValue = $this->usuNivelAcesso->FormValue;
		$this->UsuarioSexo->CurrentValue = $this->UsuarioSexo->FormValue;
		$this->UsuarioEstado->CurrentValue = $this->UsuarioEstado->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->usuarioId->setDbValue($rs->fields('usuarioId'));
		$this->nome->setDbValue($rs->fields('nome'));
		$this->UsuarioApelido->setDbValue($rs->fields('UsuarioApelido'));
		$this->usuarioNome->setDbValue($rs->fields('usuarioNome'));
		$this->UsuarioEmail->setDbValue($rs->fields('UsuarioEmail'));
		$this->usuarioSenha->setDbValue($rs->fields('usuarioSenha'));
		$this->usuNivelAcesso->setDbValue($rs->fields('usuNivelAcesso'));
		$this->UsuarioSexo->setDbValue($rs->fields('UsuarioSexo'));
		$this->UsuarioEstado->setDbValue($rs->fields('UsuarioEstado'));
		$this->usuarioAvatar->Upload->DbValue = $rs->fields('usuarioAvatar');
		$this->usuarioAvatar->CurrentValue = $this->usuarioAvatar->Upload->DbValue;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->usuarioId->DbValue = $row['usuarioId'];
		$this->nome->DbValue = $row['nome'];
		$this->UsuarioApelido->DbValue = $row['UsuarioApelido'];
		$this->usuarioNome->DbValue = $row['usuarioNome'];
		$this->UsuarioEmail->DbValue = $row['UsuarioEmail'];
		$this->usuarioSenha->DbValue = $row['usuarioSenha'];
		$this->usuNivelAcesso->DbValue = $row['usuNivelAcesso'];
		$this->UsuarioSexo->DbValue = $row['UsuarioSexo'];
		$this->UsuarioEstado->DbValue = $row['UsuarioEstado'];
		$this->usuarioAvatar->Upload->DbValue = $row['usuarioAvatar'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// usuarioId
		// nome
		// UsuarioApelido
		// usuarioNome
		// UsuarioEmail
		// usuarioSenha
		// usuNivelAcesso
		// UsuarioSexo
		// UsuarioEstado
		// usuarioAvatar

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// usuarioId
		$this->usuarioId->ViewValue = $this->usuarioId->CurrentValue;
		$this->usuarioId->ViewCustomAttributes = "";

		// nome
		$this->nome->ViewValue = $this->nome->CurrentValue;
		$this->nome->ViewCustomAttributes = "";

		// UsuarioApelido
		$this->UsuarioApelido->ViewValue = $this->UsuarioApelido->CurrentValue;
		$this->UsuarioApelido->ViewCustomAttributes = "";

		// usuarioNome
		$this->usuarioNome->ViewValue = $this->usuarioNome->CurrentValue;
		$this->usuarioNome->ViewCustomAttributes = "";

		// UsuarioEmail
		$this->UsuarioEmail->ViewValue = $this->UsuarioEmail->CurrentValue;
		$this->UsuarioEmail->ViewCustomAttributes = "";

		// usuarioSenha
		$this->usuarioSenha->ViewValue = $Language->Phrase("PasswordMask");
		$this->usuarioSenha->ViewCustomAttributes = "";

		// usuNivelAcesso
		if (strval($this->usuNivelAcesso->CurrentValue) <> "") {
			$sFilterWrk = "`usuTipoId`" . ew_SearchString("=", $this->usuNivelAcesso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `usuTipoId`, `usuTipoNome` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_tipo_usuario`";
		$sWhereWrk = "";
		$this->usuNivelAcesso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->usuNivelAcesso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->usuNivelAcesso->ViewValue = $this->usuNivelAcesso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->usuNivelAcesso->ViewValue = $this->usuNivelAcesso->CurrentValue;
			}
		} else {
			$this->usuNivelAcesso->ViewValue = NULL;
		}
		$this->usuNivelAcesso->ViewCustomAttributes = "";

		// UsuarioSexo
		if (strval($this->UsuarioSexo->CurrentValue) <> "") {
			$this->UsuarioSexo->ViewValue = $this->UsuarioSexo->OptionCaption($this->UsuarioSexo->CurrentValue);
		} else {
			$this->UsuarioSexo->ViewValue = NULL;
		}
		$this->UsuarioSexo->ViewCustomAttributes = "";

		// UsuarioEstado
		if (strval($this->UsuarioEstado->CurrentValue) <> "") {
			$sFilterWrk = "`frl_usuario_estado_id`" . ew_SearchString("=", $this->UsuarioEstado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `frl_usuario_estado_id`, `frl_usuario_estado_nome` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_usuario_estado`";
		$sWhereWrk = "";
		$this->UsuarioEstado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->UsuarioEstado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->UsuarioEstado->ViewValue = $this->UsuarioEstado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->UsuarioEstado->ViewValue = $this->UsuarioEstado->CurrentValue;
			}
		} else {
			$this->UsuarioEstado->ViewValue = NULL;
		}
		$this->UsuarioEstado->ViewCustomAttributes = "";

		// usuarioAvatar
		if (!ew_Empty($this->usuarioAvatar->Upload->DbValue)) {
			$this->usuarioAvatar->ImageWidth = 35;
			$this->usuarioAvatar->ImageHeight = 35;
			$this->usuarioAvatar->ImageAlt = $this->usuarioAvatar->FldAlt();
			$this->usuarioAvatar->ViewValue = $this->usuarioAvatar->Upload->DbValue;
		} else {
			$this->usuarioAvatar->ViewValue = "";
		}
		$this->usuarioAvatar->ViewCustomAttributes = "";

			// usuarioId
			$this->usuarioId->LinkCustomAttributes = "";
			$this->usuarioId->HrefValue = "";
			$this->usuarioId->TooltipValue = "";

			// nome
			$this->nome->LinkCustomAttributes = "";
			$this->nome->HrefValue = "";
			$this->nome->TooltipValue = "";

			// UsuarioApelido
			$this->UsuarioApelido->LinkCustomAttributes = "";
			$this->UsuarioApelido->HrefValue = "";
			$this->UsuarioApelido->TooltipValue = "";

			// usuarioNome
			$this->usuarioNome->LinkCustomAttributes = "";
			$this->usuarioNome->HrefValue = "";
			$this->usuarioNome->TooltipValue = "";

			// UsuarioEmail
			$this->UsuarioEmail->LinkCustomAttributes = "";
			$this->UsuarioEmail->HrefValue = "";
			$this->UsuarioEmail->TooltipValue = "";

			// usuarioSenha
			$this->usuarioSenha->LinkCustomAttributes = "";
			$this->usuarioSenha->HrefValue = "";
			$this->usuarioSenha->TooltipValue = "";

			// usuNivelAcesso
			$this->usuNivelAcesso->LinkCustomAttributes = "";
			$this->usuNivelAcesso->HrefValue = "";
			$this->usuNivelAcesso->TooltipValue = "";

			// UsuarioSexo
			$this->UsuarioSexo->LinkCustomAttributes = "";
			$this->UsuarioSexo->HrefValue = "";
			$this->UsuarioSexo->TooltipValue = "";

			// UsuarioEstado
			$this->UsuarioEstado->LinkCustomAttributes = "";
			$this->UsuarioEstado->HrefValue = "";
			$this->UsuarioEstado->TooltipValue = "";

			// usuarioAvatar
			$this->usuarioAvatar->LinkCustomAttributes = "";
			if (!ew_Empty($this->usuarioAvatar->Upload->DbValue)) {
				$this->usuarioAvatar->HrefValue = ew_GetFileUploadUrl($this->usuarioAvatar, $this->usuarioAvatar->Upload->DbValue); // Add prefix/suffix
				$this->usuarioAvatar->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->usuarioAvatar->HrefValue = ew_ConvertFullUrl($this->usuarioAvatar->HrefValue);
			} else {
				$this->usuarioAvatar->HrefValue = "";
			}
			$this->usuarioAvatar->HrefValue2 = $this->usuarioAvatar->UploadPath . $this->usuarioAvatar->Upload->DbValue;
			$this->usuarioAvatar->TooltipValue = "";
			if ($this->usuarioAvatar->UseColorbox) {
				if (ew_Empty($this->usuarioAvatar->TooltipValue))
					$this->usuarioAvatar->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->usuarioAvatar->LinkAttrs["data-rel"] = "frl_usuario_x_usuarioAvatar";
				ew_AppendClass($this->usuarioAvatar->LinkAttrs["class"], "ewLightbox");
			}
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// usuarioId
			$this->usuarioId->EditAttrs["class"] = "form-control";
			$this->usuarioId->EditCustomAttributes = "";
			$this->usuarioId->EditValue = $this->usuarioId->CurrentValue;
			$this->usuarioId->ViewCustomAttributes = "";

			// nome
			$this->nome->EditAttrs["class"] = "form-control";
			$this->nome->EditCustomAttributes = "";
			$this->nome->EditValue = ew_HtmlEncode($this->nome->CurrentValue);
			$this->nome->PlaceHolder = ew_RemoveHtml($this->nome->FldCaption());

			// UsuarioApelido
			$this->UsuarioApelido->EditAttrs["class"] = "form-control";
			$this->UsuarioApelido->EditCustomAttributes = "";
			$this->UsuarioApelido->EditValue = ew_HtmlEncode($this->UsuarioApelido->CurrentValue);
			$this->UsuarioApelido->PlaceHolder = ew_RemoveHtml($this->UsuarioApelido->FldCaption());

			// usuarioNome
			$this->usuarioNome->EditAttrs["class"] = "form-control";
			$this->usuarioNome->EditCustomAttributes = "";
			$this->usuarioNome->EditValue = ew_HtmlEncode($this->usuarioNome->CurrentValue);
			$this->usuarioNome->PlaceHolder = ew_RemoveHtml($this->usuarioNome->FldCaption());

			// UsuarioEmail
			$this->UsuarioEmail->EditAttrs["class"] = "form-control";
			$this->UsuarioEmail->EditCustomAttributes = "";
			$this->UsuarioEmail->EditValue = ew_HtmlEncode($this->UsuarioEmail->CurrentValue);
			$this->UsuarioEmail->PlaceHolder = ew_RemoveHtml($this->UsuarioEmail->FldCaption());

			// usuarioSenha
			$this->usuarioSenha->EditAttrs["class"] = "form-control";
			$this->usuarioSenha->EditCustomAttributes = "";
			$this->usuarioSenha->EditValue = ew_HtmlEncode($this->usuarioSenha->CurrentValue);
			$this->usuarioSenha->PlaceHolder = ew_RemoveHtml($this->usuarioSenha->FldCaption());

			// usuNivelAcesso
			$this->usuNivelAcesso->EditAttrs["class"] = "form-control";
			$this->usuNivelAcesso->EditCustomAttributes = "";
			if (trim(strval($this->usuNivelAcesso->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`usuTipoId`" . ew_SearchString("=", $this->usuNivelAcesso->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `usuTipoId`, `usuTipoNome` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `frl_tipo_usuario`";
			$sWhereWrk = "";
			$this->usuNivelAcesso->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->usuNivelAcesso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->usuNivelAcesso->EditValue = $arwrk;

			// UsuarioSexo
			$this->UsuarioSexo->EditAttrs["class"] = "form-control";
			$this->UsuarioSexo->EditCustomAttributes = "";
			$this->UsuarioSexo->EditValue = $this->UsuarioSexo->Options(TRUE);

			// UsuarioEstado
			$this->UsuarioEstado->EditAttrs["class"] = "form-control";
			$this->UsuarioEstado->EditCustomAttributes = "";
			if (trim(strval($this->UsuarioEstado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`frl_usuario_estado_id`" . ew_SearchString("=", $this->UsuarioEstado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `frl_usuario_estado_id`, `frl_usuario_estado_nome` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `frl_usuario_estado`";
			$sWhereWrk = "";
			$this->UsuarioEstado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->UsuarioEstado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->UsuarioEstado->EditValue = $arwrk;

			// usuarioAvatar
			$this->usuarioAvatar->EditAttrs["class"] = "form-control";
			$this->usuarioAvatar->EditCustomAttributes = "";
			if (!ew_Empty($this->usuarioAvatar->Upload->DbValue)) {
				$this->usuarioAvatar->ImageWidth = 35;
				$this->usuarioAvatar->ImageHeight = 35;
				$this->usuarioAvatar->ImageAlt = $this->usuarioAvatar->FldAlt();
				$this->usuarioAvatar->EditValue = $this->usuarioAvatar->Upload->DbValue;
			} else {
				$this->usuarioAvatar->EditValue = "";
			}
			if (!ew_Empty($this->usuarioAvatar->CurrentValue))
				$this->usuarioAvatar->Upload->FileName = $this->usuarioAvatar->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->usuarioAvatar);

			// Edit refer script
			// usuarioId

			$this->usuarioId->LinkCustomAttributes = "";
			$this->usuarioId->HrefValue = "";

			// nome
			$this->nome->LinkCustomAttributes = "";
			$this->nome->HrefValue = "";

			// UsuarioApelido
			$this->UsuarioApelido->LinkCustomAttributes = "";
			$this->UsuarioApelido->HrefValue = "";

			// usuarioNome
			$this->usuarioNome->LinkCustomAttributes = "";
			$this->usuarioNome->HrefValue = "";

			// UsuarioEmail
			$this->UsuarioEmail->LinkCustomAttributes = "";
			$this->UsuarioEmail->HrefValue = "";

			// usuarioSenha
			$this->usuarioSenha->LinkCustomAttributes = "";
			$this->usuarioSenha->HrefValue = "";

			// usuNivelAcesso
			$this->usuNivelAcesso->LinkCustomAttributes = "";
			$this->usuNivelAcesso->HrefValue = "";

			// UsuarioSexo
			$this->UsuarioSexo->LinkCustomAttributes = "";
			$this->UsuarioSexo->HrefValue = "";

			// UsuarioEstado
			$this->UsuarioEstado->LinkCustomAttributes = "";
			$this->UsuarioEstado->HrefValue = "";

			// usuarioAvatar
			$this->usuarioAvatar->LinkCustomAttributes = "";
			if (!ew_Empty($this->usuarioAvatar->Upload->DbValue)) {
				$this->usuarioAvatar->HrefValue = ew_GetFileUploadUrl($this->usuarioAvatar, $this->usuarioAvatar->Upload->DbValue); // Add prefix/suffix
				$this->usuarioAvatar->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->usuarioAvatar->HrefValue = ew_ConvertFullUrl($this->usuarioAvatar->HrefValue);
			} else {
				$this->usuarioAvatar->HrefValue = "";
			}
			$this->usuarioAvatar->HrefValue2 = $this->usuarioAvatar->UploadPath . $this->usuarioAvatar->Upload->DbValue;
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->nome->FldIsDetailKey && !is_null($this->nome->FormValue) && $this->nome->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nome->FldCaption(), $this->nome->ReqErrMsg));
		}
		if (!$this->UsuarioApelido->FldIsDetailKey && !is_null($this->UsuarioApelido->FormValue) && $this->UsuarioApelido->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UsuarioApelido->FldCaption(), $this->UsuarioApelido->ReqErrMsg));
		}
		if (!$this->usuarioNome->FldIsDetailKey && !is_null($this->usuarioNome->FormValue) && $this->usuarioNome->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->usuarioNome->FldCaption(), $this->usuarioNome->ReqErrMsg));
		}
		if (!$this->UsuarioEmail->FldIsDetailKey && !is_null($this->UsuarioEmail->FormValue) && $this->UsuarioEmail->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UsuarioEmail->FldCaption(), $this->UsuarioEmail->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->UsuarioEmail->FormValue)) {
			ew_AddMessage($gsFormError, $this->UsuarioEmail->FldErrMsg());
		}
		if (!$this->usuarioSenha->FldIsDetailKey && !is_null($this->usuarioSenha->FormValue) && $this->usuarioSenha->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->usuarioSenha->FldCaption(), $this->usuarioSenha->ReqErrMsg));
		}
		if (!$this->usuNivelAcesso->FldIsDetailKey && !is_null($this->usuNivelAcesso->FormValue) && $this->usuNivelAcesso->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->usuNivelAcesso->FldCaption(), $this->usuNivelAcesso->ReqErrMsg));
		}
		if (!$this->UsuarioSexo->FldIsDetailKey && !is_null($this->UsuarioSexo->FormValue) && $this->UsuarioSexo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UsuarioSexo->FldCaption(), $this->UsuarioSexo->ReqErrMsg));
		}
		if (!$this->UsuarioEstado->FldIsDetailKey && !is_null($this->UsuarioEstado->FormValue) && $this->UsuarioEstado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->UsuarioEstado->FldCaption(), $this->UsuarioEstado->ReqErrMsg));
		}
		if ($this->usuarioAvatar->Upload->FileName == "" && !$this->usuarioAvatar->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->usuarioAvatar->FldCaption(), $this->usuarioAvatar->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		if ($this->usuarioNome->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`usuarioNome` = '" . ew_AdjustSql($this->usuarioNome->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->usuarioNome->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->usuarioNome->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		if ($this->UsuarioEmail->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`UsuarioEmail` = '" . ew_AdjustSql($this->UsuarioEmail->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->UsuarioEmail->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->UsuarioEmail->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nome
			$this->nome->SetDbValueDef($rsnew, $this->nome->CurrentValue, "", $this->nome->ReadOnly);

			// UsuarioApelido
			$this->UsuarioApelido->SetDbValueDef($rsnew, $this->UsuarioApelido->CurrentValue, "", $this->UsuarioApelido->ReadOnly);

			// usuarioNome
			$this->usuarioNome->SetDbValueDef($rsnew, $this->usuarioNome->CurrentValue, "", $this->usuarioNome->ReadOnly);

			// UsuarioEmail
			$this->UsuarioEmail->SetDbValueDef($rsnew, $this->UsuarioEmail->CurrentValue, "", $this->UsuarioEmail->ReadOnly);

			// usuarioSenha
			$this->usuarioSenha->SetDbValueDef($rsnew, $this->usuarioSenha->CurrentValue, "", $this->usuarioSenha->ReadOnly);

			// usuNivelAcesso
			$this->usuNivelAcesso->SetDbValueDef($rsnew, $this->usuNivelAcesso->CurrentValue, 0, $this->usuNivelAcesso->ReadOnly);

			// UsuarioSexo
			$this->UsuarioSexo->SetDbValueDef($rsnew, $this->UsuarioSexo->CurrentValue, "", $this->UsuarioSexo->ReadOnly);

			// UsuarioEstado
			$this->UsuarioEstado->SetDbValueDef($rsnew, $this->UsuarioEstado->CurrentValue, 0, $this->UsuarioEstado->ReadOnly);

			// usuarioAvatar
			if ($this->usuarioAvatar->Visible && !$this->usuarioAvatar->ReadOnly && !$this->usuarioAvatar->Upload->KeepFile) {
				$this->usuarioAvatar->Upload->DbValue = $rsold['usuarioAvatar']; // Get original value
				if ($this->usuarioAvatar->Upload->FileName == "") {
					$rsnew['usuarioAvatar'] = NULL;
				} else {
					$rsnew['usuarioAvatar'] = $this->usuarioAvatar->Upload->FileName;
				}
				$this->usuarioAvatar->ImageWidth = 0; // Resize width
				$this->usuarioAvatar->ImageHeight = 700; // Resize height
			}
			if ($this->usuarioAvatar->Visible && !$this->usuarioAvatar->Upload->KeepFile) {
				if (!ew_Empty($this->usuarioAvatar->Upload->Value)) {
					$rsnew['usuarioAvatar'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->usuarioAvatar->UploadPath), $rsnew['usuarioAvatar']); // Get new file name
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if ($this->usuarioAvatar->Visible && !$this->usuarioAvatar->Upload->KeepFile) {
						if (!ew_Empty($this->usuarioAvatar->Upload->Value)) {
							$this->usuarioAvatar->Upload->Resize($this->usuarioAvatar->ImageWidth, $this->usuarioAvatar->ImageHeight);
							if (!$this->usuarioAvatar->Upload->SaveToFile($this->usuarioAvatar->UploadPath, $rsnew['usuarioAvatar'], TRUE)) {
								$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
								return FALSE;
							}
						}
					}
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// usuarioAvatar
		ew_CleanUploadTempPath($this->usuarioAvatar, $this->usuarioAvatar->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("frl_usuariolist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_usuNivelAcesso":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `usuTipoId` AS `LinkFld`, `usuTipoNome` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_tipo_usuario`";
			$sWhereWrk = "";
			$this->usuNivelAcesso->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`usuTipoId` = {filter_value}', "t0" => "21", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->usuNivelAcesso, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_UsuarioEstado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `frl_usuario_estado_id` AS `LinkFld`, `frl_usuario_estado_nome` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_usuario_estado`";
			$sWhereWrk = "";
			$this->UsuarioEstado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`frl_usuario_estado_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->UsuarioEstado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($frl_usuario_edit)) $frl_usuario_edit = new cfrl_usuario_edit();

// Page init
$frl_usuario_edit->Page_Init();

// Page main
$frl_usuario_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$frl_usuario_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ffrl_usuarioedit = new ew_Form("ffrl_usuarioedit", "edit");

// Validate form
ffrl_usuarioedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_nome");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->nome->FldCaption(), $frl_usuario->nome->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UsuarioApelido");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->UsuarioApelido->FldCaption(), $frl_usuario->UsuarioApelido->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_usuarioNome");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->usuarioNome->FldCaption(), $frl_usuario->usuarioNome->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UsuarioEmail");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->UsuarioEmail->FldCaption(), $frl_usuario->UsuarioEmail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UsuarioEmail");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($frl_usuario->UsuarioEmail->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_usuarioSenha");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->usuarioSenha->FldCaption(), $frl_usuario->usuarioSenha->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_usuNivelAcesso");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->usuNivelAcesso->FldCaption(), $frl_usuario->usuNivelAcesso->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UsuarioSexo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->UsuarioSexo->FldCaption(), $frl_usuario->UsuarioSexo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_UsuarioEstado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->UsuarioEstado->FldCaption(), $frl_usuario->UsuarioEstado->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_usuarioAvatar");
			elm = this.GetElements("fn_x" + infix + "_usuarioAvatar");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_usuario->usuarioAvatar->FldCaption(), $frl_usuario->usuarioAvatar->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ffrl_usuarioedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffrl_usuarioedit.ValidateRequired = true;
<?php } else { ?>
ffrl_usuarioedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffrl_usuarioedit.Lists["x_usuNivelAcesso"] = {"LinkField":"x_usuTipoId","Ajax":true,"AutoFill":false,"DisplayFields":["x_usuTipoNome","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"frl_tipo_usuario"};
ffrl_usuarioedit.Lists["x_UsuarioSexo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffrl_usuarioedit.Lists["x_UsuarioSexo"].Options = <?php echo json_encode($frl_usuario->UsuarioSexo->Options()) ?>;
ffrl_usuarioedit.Lists["x_UsuarioEstado"] = {"LinkField":"x_frl_usuario_estado_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_frl_usuario_estado_nome","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"frl_usuario_estado"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$frl_usuario_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $frl_usuario_edit->ShowPageHeader(); ?>
<?php
$frl_usuario_edit->ShowMessage();
?>
<form name="ffrl_usuarioedit" id="ffrl_usuarioedit" class="<?php echo $frl_usuario_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($frl_usuario_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $frl_usuario_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="frl_usuario">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($frl_usuario_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($frl_usuario->usuarioId->Visible) { // usuarioId ?>
	<div id="r_usuarioId" class="form-group">
		<label id="elh_frl_usuario_usuarioId" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->usuarioId->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->usuarioId->CellAttributes() ?>>
<span id="el_frl_usuario_usuarioId">
<span<?php echo $frl_usuario->usuarioId->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $frl_usuario->usuarioId->EditValue ?></p></span>
</span>
<input type="hidden" data-table="frl_usuario" data-field="x_usuarioId" name="x_usuarioId" id="x_usuarioId" value="<?php echo ew_HtmlEncode($frl_usuario->usuarioId->CurrentValue) ?>">
<?php echo $frl_usuario->usuarioId->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->nome->Visible) { // nome ?>
	<div id="r_nome" class="form-group">
		<label id="elh_frl_usuario_nome" for="x_nome" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->nome->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->nome->CellAttributes() ?>>
<span id="el_frl_usuario_nome">
<input type="text" data-table="frl_usuario" data-field="x_nome" name="x_nome" id="x_nome" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($frl_usuario->nome->getPlaceHolder()) ?>" value="<?php echo $frl_usuario->nome->EditValue ?>"<?php echo $frl_usuario->nome->EditAttributes() ?>>
</span>
<?php echo $frl_usuario->nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->UsuarioApelido->Visible) { // UsuarioApelido ?>
	<div id="r_UsuarioApelido" class="form-group">
		<label id="elh_frl_usuario_UsuarioApelido" for="x_UsuarioApelido" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->UsuarioApelido->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->UsuarioApelido->CellAttributes() ?>>
<span id="el_frl_usuario_UsuarioApelido">
<input type="text" data-table="frl_usuario" data-field="x_UsuarioApelido" name="x_UsuarioApelido" id="x_UsuarioApelido" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($frl_usuario->UsuarioApelido->getPlaceHolder()) ?>" value="<?php echo $frl_usuario->UsuarioApelido->EditValue ?>"<?php echo $frl_usuario->UsuarioApelido->EditAttributes() ?>>
</span>
<?php echo $frl_usuario->UsuarioApelido->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->usuarioNome->Visible) { // usuarioNome ?>
	<div id="r_usuarioNome" class="form-group">
		<label id="elh_frl_usuario_usuarioNome" for="x_usuarioNome" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->usuarioNome->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->usuarioNome->CellAttributes() ?>>
<span id="el_frl_usuario_usuarioNome">
<input type="text" data-table="frl_usuario" data-field="x_usuarioNome" name="x_usuarioNome" id="x_usuarioNome" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($frl_usuario->usuarioNome->getPlaceHolder()) ?>" value="<?php echo $frl_usuario->usuarioNome->EditValue ?>"<?php echo $frl_usuario->usuarioNome->EditAttributes() ?>>
</span>
<?php echo $frl_usuario->usuarioNome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->UsuarioEmail->Visible) { // UsuarioEmail ?>
	<div id="r_UsuarioEmail" class="form-group">
		<label id="elh_frl_usuario_UsuarioEmail" for="x_UsuarioEmail" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->UsuarioEmail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->UsuarioEmail->CellAttributes() ?>>
<span id="el_frl_usuario_UsuarioEmail">
<input type="text" data-table="frl_usuario" data-field="x_UsuarioEmail" name="x_UsuarioEmail" id="x_UsuarioEmail" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($frl_usuario->UsuarioEmail->getPlaceHolder()) ?>" value="<?php echo $frl_usuario->UsuarioEmail->EditValue ?>"<?php echo $frl_usuario->UsuarioEmail->EditAttributes() ?>>
</span>
<?php echo $frl_usuario->UsuarioEmail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->usuarioSenha->Visible) { // usuarioSenha ?>
	<div id="r_usuarioSenha" class="form-group">
		<label id="elh_frl_usuario_usuarioSenha" for="x_usuarioSenha" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->usuarioSenha->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->usuarioSenha->CellAttributes() ?>>
<span id="el_frl_usuario_usuarioSenha">
<input type="password" data-field="x_usuarioSenha" name="x_usuarioSenha" id="x_usuarioSenha" value="<?php echo $frl_usuario->usuarioSenha->EditValue ?>" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($frl_usuario->usuarioSenha->getPlaceHolder()) ?>"<?php echo $frl_usuario->usuarioSenha->EditAttributes() ?>>
</span>
<?php echo $frl_usuario->usuarioSenha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->usuNivelAcesso->Visible) { // usuNivelAcesso ?>
	<div id="r_usuNivelAcesso" class="form-group">
		<label id="elh_frl_usuario_usuNivelAcesso" for="x_usuNivelAcesso" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->usuNivelAcesso->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->usuNivelAcesso->CellAttributes() ?>>
<span id="el_frl_usuario_usuNivelAcesso">
<select data-table="frl_usuario" data-field="x_usuNivelAcesso" data-value-separator="<?php echo $frl_usuario->usuNivelAcesso->DisplayValueSeparatorAttribute() ?>" id="x_usuNivelAcesso" name="x_usuNivelAcesso"<?php echo $frl_usuario->usuNivelAcesso->EditAttributes() ?>>
<?php echo $frl_usuario->usuNivelAcesso->SelectOptionListHtml("x_usuNivelAcesso") ?>
</select>
<input type="hidden" name="s_x_usuNivelAcesso" id="s_x_usuNivelAcesso" value="<?php echo $frl_usuario->usuNivelAcesso->LookupFilterQuery() ?>">
</span>
<?php echo $frl_usuario->usuNivelAcesso->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->UsuarioSexo->Visible) { // UsuarioSexo ?>
	<div id="r_UsuarioSexo" class="form-group">
		<label id="elh_frl_usuario_UsuarioSexo" for="x_UsuarioSexo" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->UsuarioSexo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->UsuarioSexo->CellAttributes() ?>>
<span id="el_frl_usuario_UsuarioSexo">
<select data-table="frl_usuario" data-field="x_UsuarioSexo" data-value-separator="<?php echo $frl_usuario->UsuarioSexo->DisplayValueSeparatorAttribute() ?>" id="x_UsuarioSexo" name="x_UsuarioSexo"<?php echo $frl_usuario->UsuarioSexo->EditAttributes() ?>>
<?php echo $frl_usuario->UsuarioSexo->SelectOptionListHtml("x_UsuarioSexo") ?>
</select>
</span>
<?php echo $frl_usuario->UsuarioSexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->UsuarioEstado->Visible) { // UsuarioEstado ?>
	<div id="r_UsuarioEstado" class="form-group">
		<label id="elh_frl_usuario_UsuarioEstado" for="x_UsuarioEstado" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->UsuarioEstado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->UsuarioEstado->CellAttributes() ?>>
<span id="el_frl_usuario_UsuarioEstado">
<select data-table="frl_usuario" data-field="x_UsuarioEstado" data-value-separator="<?php echo $frl_usuario->UsuarioEstado->DisplayValueSeparatorAttribute() ?>" id="x_UsuarioEstado" name="x_UsuarioEstado"<?php echo $frl_usuario->UsuarioEstado->EditAttributes() ?>>
<?php echo $frl_usuario->UsuarioEstado->SelectOptionListHtml("x_UsuarioEstado") ?>
</select>
<input type="hidden" name="s_x_UsuarioEstado" id="s_x_UsuarioEstado" value="<?php echo $frl_usuario->UsuarioEstado->LookupFilterQuery() ?>">
</span>
<?php echo $frl_usuario->UsuarioEstado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_usuario->usuarioAvatar->Visible) { // usuarioAvatar ?>
	<div id="r_usuarioAvatar" class="form-group">
		<label id="elh_frl_usuario_usuarioAvatar" class="col-sm-2 control-label ewLabel"><?php echo $frl_usuario->usuarioAvatar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_usuario->usuarioAvatar->CellAttributes() ?>>
<span id="el_frl_usuario_usuarioAvatar">
<div id="fd_x_usuarioAvatar">
<span title="<?php echo $frl_usuario->usuarioAvatar->FldTitle() ? $frl_usuario->usuarioAvatar->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($frl_usuario->usuarioAvatar->ReadOnly || $frl_usuario->usuarioAvatar->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="frl_usuario" data-field="x_usuarioAvatar" name="x_usuarioAvatar" id="x_usuarioAvatar"<?php echo $frl_usuario->usuarioAvatar->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_usuarioAvatar" id= "fn_x_usuarioAvatar" value="<?php echo $frl_usuario->usuarioAvatar->Upload->FileName ?>">
<?php if (@$_POST["fa_x_usuarioAvatar"] == "0") { ?>
<input type="hidden" name="fa_x_usuarioAvatar" id= "fa_x_usuarioAvatar" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_usuarioAvatar" id= "fa_x_usuarioAvatar" value="1">
<?php } ?>
<input type="hidden" name="fs_x_usuarioAvatar" id= "fs_x_usuarioAvatar" value="250">
<input type="hidden" name="fx_x_usuarioAvatar" id= "fx_x_usuarioAvatar" value="<?php echo $frl_usuario->usuarioAvatar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_usuarioAvatar" id= "fm_x_usuarioAvatar" value="<?php echo $frl_usuario->usuarioAvatar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_usuarioAvatar" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $frl_usuario->usuarioAvatar->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$frl_usuario_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $frl_usuario_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ffrl_usuarioedit.Init();
</script>
<?php
$frl_usuario_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$frl_usuario_edit->Page_Terminate();
?>
