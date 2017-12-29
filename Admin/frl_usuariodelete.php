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

$frl_usuario_delete = NULL; // Initialize page object first

class cfrl_usuario_delete extends cfrl_usuario {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{286C4D49-9D44-49E9-A580-A7321FF88E9C}";

	// Table name
	var $TableName = 'frl_usuario';

	// Page object name
	var $PageObjName = 'frl_usuario_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("frl_usuariolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in frl_usuario class, frl_usuarioinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("frl_usuariolist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['usuarioId'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("frl_usuariolist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($frl_usuario_delete)) $frl_usuario_delete = new cfrl_usuario_delete();

// Page init
$frl_usuario_delete->Page_Init();

// Page main
$frl_usuario_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$frl_usuario_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ffrl_usuariodelete = new ew_Form("ffrl_usuariodelete", "delete");

// Form_CustomValidate event
ffrl_usuariodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffrl_usuariodelete.ValidateRequired = true;
<?php } else { ?>
ffrl_usuariodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffrl_usuariodelete.Lists["x_usuNivelAcesso"] = {"LinkField":"x_usuTipoId","Ajax":true,"AutoFill":false,"DisplayFields":["x_usuTipoNome","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"frl_tipo_usuario"};
ffrl_usuariodelete.Lists["x_UsuarioSexo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ffrl_usuariodelete.Lists["x_UsuarioSexo"].Options = <?php echo json_encode($frl_usuario->UsuarioSexo->Options()) ?>;
ffrl_usuariodelete.Lists["x_UsuarioEstado"] = {"LinkField":"x_frl_usuario_estado_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_frl_usuario_estado_nome","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"frl_usuario_estado"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $frl_usuario_delete->ShowPageHeader(); ?>
<?php
$frl_usuario_delete->ShowMessage();
?>
<form name="ffrl_usuariodelete" id="ffrl_usuariodelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($frl_usuario_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $frl_usuario_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="frl_usuario">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($frl_usuario_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $frl_usuario->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($frl_usuario->usuarioId->Visible) { // usuarioId ?>
		<th><span id="elh_frl_usuario_usuarioId" class="frl_usuario_usuarioId"><?php echo $frl_usuario->usuarioId->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->nome->Visible) { // nome ?>
		<th><span id="elh_frl_usuario_nome" class="frl_usuario_nome"><?php echo $frl_usuario->nome->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->UsuarioApelido->Visible) { // UsuarioApelido ?>
		<th><span id="elh_frl_usuario_UsuarioApelido" class="frl_usuario_UsuarioApelido"><?php echo $frl_usuario->UsuarioApelido->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->usuarioNome->Visible) { // usuarioNome ?>
		<th><span id="elh_frl_usuario_usuarioNome" class="frl_usuario_usuarioNome"><?php echo $frl_usuario->usuarioNome->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->UsuarioEmail->Visible) { // UsuarioEmail ?>
		<th><span id="elh_frl_usuario_UsuarioEmail" class="frl_usuario_UsuarioEmail"><?php echo $frl_usuario->UsuarioEmail->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->usuarioSenha->Visible) { // usuarioSenha ?>
		<th><span id="elh_frl_usuario_usuarioSenha" class="frl_usuario_usuarioSenha"><?php echo $frl_usuario->usuarioSenha->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->usuNivelAcesso->Visible) { // usuNivelAcesso ?>
		<th><span id="elh_frl_usuario_usuNivelAcesso" class="frl_usuario_usuNivelAcesso"><?php echo $frl_usuario->usuNivelAcesso->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->UsuarioSexo->Visible) { // UsuarioSexo ?>
		<th><span id="elh_frl_usuario_UsuarioSexo" class="frl_usuario_UsuarioSexo"><?php echo $frl_usuario->UsuarioSexo->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->UsuarioEstado->Visible) { // UsuarioEstado ?>
		<th><span id="elh_frl_usuario_UsuarioEstado" class="frl_usuario_UsuarioEstado"><?php echo $frl_usuario->UsuarioEstado->FldCaption() ?></span></th>
<?php } ?>
<?php if ($frl_usuario->usuarioAvatar->Visible) { // usuarioAvatar ?>
		<th><span id="elh_frl_usuario_usuarioAvatar" class="frl_usuario_usuarioAvatar"><?php echo $frl_usuario->usuarioAvatar->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$frl_usuario_delete->RecCnt = 0;
$i = 0;
while (!$frl_usuario_delete->Recordset->EOF) {
	$frl_usuario_delete->RecCnt++;
	$frl_usuario_delete->RowCnt++;

	// Set row properties
	$frl_usuario->ResetAttrs();
	$frl_usuario->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$frl_usuario_delete->LoadRowValues($frl_usuario_delete->Recordset);

	// Render row
	$frl_usuario_delete->RenderRow();
?>
	<tr<?php echo $frl_usuario->RowAttributes() ?>>
<?php if ($frl_usuario->usuarioId->Visible) { // usuarioId ?>
		<td<?php echo $frl_usuario->usuarioId->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_usuarioId" class="frl_usuario_usuarioId">
<span<?php echo $frl_usuario->usuarioId->ViewAttributes() ?>>
<?php echo $frl_usuario->usuarioId->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->nome->Visible) { // nome ?>
		<td<?php echo $frl_usuario->nome->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_nome" class="frl_usuario_nome">
<span<?php echo $frl_usuario->nome->ViewAttributes() ?>>
<?php echo $frl_usuario->nome->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->UsuarioApelido->Visible) { // UsuarioApelido ?>
		<td<?php echo $frl_usuario->UsuarioApelido->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_UsuarioApelido" class="frl_usuario_UsuarioApelido">
<span<?php echo $frl_usuario->UsuarioApelido->ViewAttributes() ?>>
<?php echo $frl_usuario->UsuarioApelido->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->usuarioNome->Visible) { // usuarioNome ?>
		<td<?php echo $frl_usuario->usuarioNome->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_usuarioNome" class="frl_usuario_usuarioNome">
<span<?php echo $frl_usuario->usuarioNome->ViewAttributes() ?>>
<?php echo $frl_usuario->usuarioNome->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->UsuarioEmail->Visible) { // UsuarioEmail ?>
		<td<?php echo $frl_usuario->UsuarioEmail->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_UsuarioEmail" class="frl_usuario_UsuarioEmail">
<span<?php echo $frl_usuario->UsuarioEmail->ViewAttributes() ?>>
<?php echo $frl_usuario->UsuarioEmail->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->usuarioSenha->Visible) { // usuarioSenha ?>
		<td<?php echo $frl_usuario->usuarioSenha->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_usuarioSenha" class="frl_usuario_usuarioSenha">
<span<?php echo $frl_usuario->usuarioSenha->ViewAttributes() ?>>
<?php echo $frl_usuario->usuarioSenha->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->usuNivelAcesso->Visible) { // usuNivelAcesso ?>
		<td<?php echo $frl_usuario->usuNivelAcesso->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_usuNivelAcesso" class="frl_usuario_usuNivelAcesso">
<span<?php echo $frl_usuario->usuNivelAcesso->ViewAttributes() ?>>
<?php echo $frl_usuario->usuNivelAcesso->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->UsuarioSexo->Visible) { // UsuarioSexo ?>
		<td<?php echo $frl_usuario->UsuarioSexo->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_UsuarioSexo" class="frl_usuario_UsuarioSexo">
<span<?php echo $frl_usuario->UsuarioSexo->ViewAttributes() ?>>
<?php echo $frl_usuario->UsuarioSexo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->UsuarioEstado->Visible) { // UsuarioEstado ?>
		<td<?php echo $frl_usuario->UsuarioEstado->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_UsuarioEstado" class="frl_usuario_UsuarioEstado">
<span<?php echo $frl_usuario->UsuarioEstado->ViewAttributes() ?>>
<?php echo $frl_usuario->UsuarioEstado->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($frl_usuario->usuarioAvatar->Visible) { // usuarioAvatar ?>
		<td<?php echo $frl_usuario->usuarioAvatar->CellAttributes() ?>>
<span id="el<?php echo $frl_usuario_delete->RowCnt ?>_frl_usuario_usuarioAvatar" class="frl_usuario_usuarioAvatar">
<span>
<?php echo ew_GetFileViewTag($frl_usuario->usuarioAvatar, $frl_usuario->usuarioAvatar->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$frl_usuario_delete->Recordset->MoveNext();
}
$frl_usuario_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $frl_usuario_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ffrl_usuariodelete.Init();
</script>
<?php
$frl_usuario_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$frl_usuario_delete->Page_Terminate();
?>
