<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "frl_celulainfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$frl_celula_edit = NULL; // Initialize page object first

class cfrl_celula_edit extends cfrl_celula {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{286C4D49-9D44-49E9-A580-A7321FF88E9C}";

	// Table name
	var $TableName = 'frl_celula';

	// Page object name
	var $PageObjName = 'frl_celula_edit';

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

		// Table object (frl_celula)
		if (!isset($GLOBALS["frl_celula"]) || get_class($GLOBALS["frl_celula"]) == "cfrl_celula") {
			$GLOBALS["frl_celula"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["frl_celula"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'frl_celula', TRUE);

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
		$this->frl_cel_id->SetVisibility();
		$this->frl_cel_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->celula->SetVisibility();
		$this->cod_provincia->SetVisibility();
		$this->cod_distrito->SetVisibility();
		$this->cod_zona->SetVisibility();
		$this->cod_circulo->SetVisibility();

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
		global $EW_EXPORT, $frl_celula;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($frl_celula);
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
		if (@$_GET["frl_cel_id"] <> "") {
			$this->frl_cel_id->setQueryStringValue($_GET["frl_cel_id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->frl_cel_id->CurrentValue == "") {
			$this->Page_Terminate("frl_celulalist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("frl_celulalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "frl_celulalist.php")
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
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->frl_cel_id->FldIsDetailKey)
			$this->frl_cel_id->setFormValue($objForm->GetValue("x_frl_cel_id"));
		if (!$this->celula->FldIsDetailKey) {
			$this->celula->setFormValue($objForm->GetValue("x_celula"));
		}
		if (!$this->cod_provincia->FldIsDetailKey) {
			$this->cod_provincia->setFormValue($objForm->GetValue("x_cod_provincia"));
		}
		if (!$this->cod_distrito->FldIsDetailKey) {
			$this->cod_distrito->setFormValue($objForm->GetValue("x_cod_distrito"));
		}
		if (!$this->cod_zona->FldIsDetailKey) {
			$this->cod_zona->setFormValue($objForm->GetValue("x_cod_zona"));
		}
		if (!$this->cod_circulo->FldIsDetailKey) {
			$this->cod_circulo->setFormValue($objForm->GetValue("x_cod_circulo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->frl_cel_id->CurrentValue = $this->frl_cel_id->FormValue;
		$this->celula->CurrentValue = $this->celula->FormValue;
		$this->cod_provincia->CurrentValue = $this->cod_provincia->FormValue;
		$this->cod_distrito->CurrentValue = $this->cod_distrito->FormValue;
		$this->cod_zona->CurrentValue = $this->cod_zona->FormValue;
		$this->cod_circulo->CurrentValue = $this->cod_circulo->FormValue;
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
		$this->frl_cel_id->setDbValue($rs->fields('frl_cel_id'));
		$this->celula->setDbValue($rs->fields('celula'));
		$this->cod_provincia->setDbValue($rs->fields('cod_provincia'));
		$this->cod_distrito->setDbValue($rs->fields('cod_distrito'));
		$this->cod_zona->setDbValue($rs->fields('cod_zona'));
		$this->cod_circulo->setDbValue($rs->fields('cod_circulo'));
		$this->populacao->setDbValue($rs->fields('populacao'));
		$this->eleitores->setDbValue($rs->fields('eleitores'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->frl_cel_id->DbValue = $row['frl_cel_id'];
		$this->celula->DbValue = $row['celula'];
		$this->cod_provincia->DbValue = $row['cod_provincia'];
		$this->cod_distrito->DbValue = $row['cod_distrito'];
		$this->cod_zona->DbValue = $row['cod_zona'];
		$this->cod_circulo->DbValue = $row['cod_circulo'];
		$this->populacao->DbValue = $row['populacao'];
		$this->eleitores->DbValue = $row['eleitores'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// frl_cel_id
		// celula
		// cod_provincia
		// cod_distrito
		// cod_zona
		// cod_circulo
		// populacao
		// eleitores

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// frl_cel_id
		$this->frl_cel_id->ViewValue = $this->frl_cel_id->CurrentValue;
		$this->frl_cel_id->ViewCustomAttributes = "";

		// celula
		$this->celula->ViewValue = $this->celula->CurrentValue;
		$this->celula->ViewCustomAttributes = "";

		// cod_provincia
		if (strval($this->cod_provincia->CurrentValue) <> "") {
			$sFilterWrk = "`sms_pro_id`" . ew_SearchString("=", $this->cod_provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `sms_pro_id`, `provincia` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sms_provincias`";
		$sWhereWrk = "";
		$this->cod_provincia->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cod_provincia, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cod_provincia->ViewValue = $this->cod_provincia->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cod_provincia->ViewValue = $this->cod_provincia->CurrentValue;
			}
		} else {
			$this->cod_provincia->ViewValue = NULL;
		}
		$this->cod_provincia->ViewCustomAttributes = "";

		// cod_distrito
		if (strval($this->cod_distrito->CurrentValue) <> "") {
			$sFilterWrk = "`sms_dis_id`" . ew_SearchString("=", $this->cod_distrito->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `sms_dis_id`, `distrito` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sms_distritos`";
		$sWhereWrk = "";
		$this->cod_distrito->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cod_distrito, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cod_distrito->ViewValue = $this->cod_distrito->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cod_distrito->ViewValue = $this->cod_distrito->CurrentValue;
			}
		} else {
			$this->cod_distrito->ViewValue = NULL;
		}
		$this->cod_distrito->ViewCustomAttributes = "";

		// cod_zona
		if (strval($this->cod_zona->CurrentValue) <> "") {
			$sFilterWrk = "`frl_zon_id`" . ew_SearchString("=", $this->cod_zona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `frl_zon_id`, `zona` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_zona`";
		$sWhereWrk = "";
		$this->cod_zona->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cod_zona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cod_zona->ViewValue = $this->cod_zona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cod_zona->ViewValue = $this->cod_zona->CurrentValue;
			}
		} else {
			$this->cod_zona->ViewValue = NULL;
		}
		$this->cod_zona->ViewCustomAttributes = "";

		// cod_circulo
		if (strval($this->cod_circulo->CurrentValue) <> "") {
			$sFilterWrk = "`frl_cir_id`" . ew_SearchString("=", $this->cod_circulo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `frl_cir_id`, `circulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_circulo`";
		$sWhereWrk = "";
		$this->cod_circulo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cod_circulo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cod_circulo->ViewValue = $this->cod_circulo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cod_circulo->ViewValue = $this->cod_circulo->CurrentValue;
			}
		} else {
			$this->cod_circulo->ViewValue = NULL;
		}
		$this->cod_circulo->ViewCustomAttributes = "";

			// frl_cel_id
			$this->frl_cel_id->LinkCustomAttributes = "";
			$this->frl_cel_id->HrefValue = "";
			$this->frl_cel_id->TooltipValue = "";

			// celula
			$this->celula->LinkCustomAttributes = "";
			$this->celula->HrefValue = "";
			$this->celula->TooltipValue = "";

			// cod_provincia
			$this->cod_provincia->LinkCustomAttributes = "";
			$this->cod_provincia->HrefValue = "";
			$this->cod_provincia->TooltipValue = "";

			// cod_distrito
			$this->cod_distrito->LinkCustomAttributes = "";
			$this->cod_distrito->HrefValue = "";
			$this->cod_distrito->TooltipValue = "";

			// cod_zona
			$this->cod_zona->LinkCustomAttributes = "";
			$this->cod_zona->HrefValue = "";
			$this->cod_zona->TooltipValue = "";

			// cod_circulo
			$this->cod_circulo->LinkCustomAttributes = "";
			$this->cod_circulo->HrefValue = "";
			$this->cod_circulo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// frl_cel_id
			$this->frl_cel_id->EditAttrs["class"] = "form-control";
			$this->frl_cel_id->EditCustomAttributes = "";
			$this->frl_cel_id->EditValue = $this->frl_cel_id->CurrentValue;
			$this->frl_cel_id->ViewCustomAttributes = "";

			// celula
			$this->celula->EditAttrs["class"] = "form-control";
			$this->celula->EditCustomAttributes = "";
			$this->celula->EditValue = ew_HtmlEncode($this->celula->CurrentValue);
			$this->celula->PlaceHolder = ew_RemoveHtml($this->celula->FldCaption());

			// cod_provincia
			$this->cod_provincia->EditAttrs["class"] = "form-control";
			$this->cod_provincia->EditCustomAttributes = "";
			if (trim(strval($this->cod_provincia->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`sms_pro_id`" . ew_SearchString("=", $this->cod_provincia->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `sms_pro_id`, `provincia` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sms_provincias`";
			$sWhereWrk = "";
			$this->cod_provincia->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cod_provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->cod_provincia->EditValue = $arwrk;

			// cod_distrito
			$this->cod_distrito->EditAttrs["class"] = "form-control";
			$this->cod_distrito->EditCustomAttributes = "";
			if (trim(strval($this->cod_distrito->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`sms_dis_id`" . ew_SearchString("=", $this->cod_distrito->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `sms_dis_id`, `distrito` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `cod_provincia` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sms_distritos`";
			$sWhereWrk = "";
			$this->cod_distrito->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cod_distrito, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->cod_distrito->EditValue = $arwrk;

			// cod_zona
			$this->cod_zona->EditAttrs["class"] = "form-control";
			$this->cod_zona->EditCustomAttributes = "";
			if (trim(strval($this->cod_zona->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`frl_zon_id`" . ew_SearchString("=", $this->cod_zona->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `frl_zon_id`, `zona` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `cod_distrito` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `frl_zona`";
			$sWhereWrk = "";
			$this->cod_zona->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cod_zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->cod_zona->EditValue = $arwrk;

			// cod_circulo
			$this->cod_circulo->EditAttrs["class"] = "form-control";
			$this->cod_circulo->EditCustomAttributes = "";
			if (trim(strval($this->cod_circulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`frl_cir_id`" . ew_SearchString("=", $this->cod_circulo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `frl_cir_id`, `circulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `cod_zona` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `frl_circulo`";
			$sWhereWrk = "";
			$this->cod_circulo->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cod_circulo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->cod_circulo->EditValue = $arwrk;

			// Edit refer script
			// frl_cel_id

			$this->frl_cel_id->LinkCustomAttributes = "";
			$this->frl_cel_id->HrefValue = "";
			$this->frl_cel_id->TooltipValue = "";

			// celula
			$this->celula->LinkCustomAttributes = "";
			$this->celula->HrefValue = "";

			// cod_provincia
			$this->cod_provincia->LinkCustomAttributes = "";
			$this->cod_provincia->HrefValue = "";

			// cod_distrito
			$this->cod_distrito->LinkCustomAttributes = "";
			$this->cod_distrito->HrefValue = "";

			// cod_zona
			$this->cod_zona->LinkCustomAttributes = "";
			$this->cod_zona->HrefValue = "";

			// cod_circulo
			$this->cod_circulo->LinkCustomAttributes = "";
			$this->cod_circulo->HrefValue = "";
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
		if (!$this->celula->FldIsDetailKey && !is_null($this->celula->FormValue) && $this->celula->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->celula->FldCaption(), $this->celula->ReqErrMsg));
		}
		if (!$this->cod_provincia->FldIsDetailKey && !is_null($this->cod_provincia->FormValue) && $this->cod_provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_provincia->FldCaption(), $this->cod_provincia->ReqErrMsg));
		}
		if (!$this->cod_distrito->FldIsDetailKey && !is_null($this->cod_distrito->FormValue) && $this->cod_distrito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_distrito->FldCaption(), $this->cod_distrito->ReqErrMsg));
		}
		if (!$this->cod_zona->FldIsDetailKey && !is_null($this->cod_zona->FormValue) && $this->cod_zona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_zona->FldCaption(), $this->cod_zona->ReqErrMsg));
		}
		if (!$this->cod_circulo->FldIsDetailKey && !is_null($this->cod_circulo->FormValue) && $this->cod_circulo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_circulo->FldCaption(), $this->cod_circulo->ReqErrMsg));
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

			// celula
			$this->celula->SetDbValueDef($rsnew, $this->celula->CurrentValue, "", $this->celula->ReadOnly);

			// cod_provincia
			$this->cod_provincia->SetDbValueDef($rsnew, $this->cod_provincia->CurrentValue, 0, $this->cod_provincia->ReadOnly);

			// cod_distrito
			$this->cod_distrito->SetDbValueDef($rsnew, $this->cod_distrito->CurrentValue, 0, $this->cod_distrito->ReadOnly);

			// cod_zona
			$this->cod_zona->SetDbValueDef($rsnew, $this->cod_zona->CurrentValue, 0, $this->cod_zona->ReadOnly);

			// cod_circulo
			$this->cod_circulo->SetDbValueDef($rsnew, $this->cod_circulo->CurrentValue, 0, $this->cod_circulo->ReadOnly);

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
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("frl_celulalist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_cod_provincia":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `sms_pro_id` AS `LinkFld`, `provincia` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sms_provincias`";
			$sWhereWrk = "";
			$this->cod_provincia->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`sms_pro_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->cod_provincia, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_cod_distrito":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `sms_dis_id` AS `LinkFld`, `distrito` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sms_distritos`";
			$sWhereWrk = "{filter}";
			$this->cod_distrito->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`sms_dis_id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`cod_provincia` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->cod_distrito, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_cod_zona":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `frl_zon_id` AS `LinkFld`, `zona` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_zona`";
			$sWhereWrk = "{filter}";
			$this->cod_zona->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`frl_zon_id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`cod_distrito` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->cod_zona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_cod_circulo":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `frl_cir_id` AS `LinkFld`, `circulo` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `frl_circulo`";
			$sWhereWrk = "{filter}";
			$this->cod_circulo->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`frl_cir_id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`cod_zona` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->cod_circulo, $sWhereWrk); // Call Lookup selecting
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
if (!isset($frl_celula_edit)) $frl_celula_edit = new cfrl_celula_edit();

// Page init
$frl_celula_edit->Page_Init();

// Page main
$frl_celula_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$frl_celula_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ffrl_celulaedit = new ew_Form("ffrl_celulaedit", "edit");

// Validate form
ffrl_celulaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_celula");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_celula->celula->FldCaption(), $frl_celula->celula->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_provincia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_celula->cod_provincia->FldCaption(), $frl_celula->cod_provincia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_distrito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_celula->cod_distrito->FldCaption(), $frl_celula->cod_distrito->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_zona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_celula->cod_zona->FldCaption(), $frl_celula->cod_zona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_circulo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_celula->cod_circulo->FldCaption(), $frl_celula->cod_circulo->ReqErrMsg)) ?>");

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
ffrl_celulaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffrl_celulaedit.ValidateRequired = true;
<?php } else { ?>
ffrl_celulaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffrl_celulaedit.Lists["x_cod_provincia"] = {"LinkField":"x_sms_pro_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_provincia","","",""],"ParentFields":[],"ChildFields":["x_cod_distrito"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sms_provincias"};
ffrl_celulaedit.Lists["x_cod_distrito"] = {"LinkField":"x_sms_dis_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_distrito","","",""],"ParentFields":["x_cod_provincia"],"ChildFields":["x_cod_zona"],"FilterFields":["x_cod_provincia"],"Options":[],"Template":"","LinkTable":"sms_distritos"};
ffrl_celulaedit.Lists["x_cod_zona"] = {"LinkField":"x_frl_zon_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_zona","","",""],"ParentFields":["x_cod_distrito"],"ChildFields":["x_cod_circulo"],"FilterFields":["x_cod_distrito"],"Options":[],"Template":"","LinkTable":"frl_zona"};
ffrl_celulaedit.Lists["x_cod_circulo"] = {"LinkField":"x_frl_cir_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_circulo","","",""],"ParentFields":["x_cod_zona"],"ChildFields":[],"FilterFields":["x_cod_zona"],"Options":[],"Template":"","LinkTable":"frl_circulo"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$frl_celula_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $frl_celula_edit->ShowPageHeader(); ?>
<?php
$frl_celula_edit->ShowMessage();
?>
<form name="ffrl_celulaedit" id="ffrl_celulaedit" class="<?php echo $frl_celula_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($frl_celula_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $frl_celula_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="frl_celula">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($frl_celula_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($frl_celula->frl_cel_id->Visible) { // frl_cel_id ?>
	<div id="r_frl_cel_id" class="form-group">
		<label id="elh_frl_celula_frl_cel_id" class="col-sm-2 control-label ewLabel"><?php echo $frl_celula->frl_cel_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $frl_celula->frl_cel_id->CellAttributes() ?>>
<span id="el_frl_celula_frl_cel_id">
<span<?php echo $frl_celula->frl_cel_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $frl_celula->frl_cel_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="frl_celula" data-field="x_frl_cel_id" name="x_frl_cel_id" id="x_frl_cel_id" value="<?php echo ew_HtmlEncode($frl_celula->frl_cel_id->CurrentValue) ?>">
<?php echo $frl_celula->frl_cel_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_celula->celula->Visible) { // celula ?>
	<div id="r_celula" class="form-group">
		<label id="elh_frl_celula_celula" for="x_celula" class="col-sm-2 control-label ewLabel"><?php echo $frl_celula->celula->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_celula->celula->CellAttributes() ?>>
<span id="el_frl_celula_celula">
<input type="text" data-table="frl_celula" data-field="x_celula" name="x_celula" id="x_celula" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($frl_celula->celula->getPlaceHolder()) ?>" value="<?php echo $frl_celula->celula->EditValue ?>"<?php echo $frl_celula->celula->EditAttributes() ?>>
</span>
<?php echo $frl_celula->celula->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_celula->cod_provincia->Visible) { // cod_provincia ?>
	<div id="r_cod_provincia" class="form-group">
		<label id="elh_frl_celula_cod_provincia" for="x_cod_provincia" class="col-sm-2 control-label ewLabel"><?php echo $frl_celula->cod_provincia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_celula->cod_provincia->CellAttributes() ?>>
<span id="el_frl_celula_cod_provincia">
<?php $frl_celula->cod_provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$frl_celula->cod_provincia->EditAttrs["onchange"]; ?>
<select data-table="frl_celula" data-field="x_cod_provincia" data-value-separator="<?php echo $frl_celula->cod_provincia->DisplayValueSeparatorAttribute() ?>" id="x_cod_provincia" name="x_cod_provincia"<?php echo $frl_celula->cod_provincia->EditAttributes() ?>>
<?php echo $frl_celula->cod_provincia->SelectOptionListHtml("x_cod_provincia") ?>
</select>
<input type="hidden" name="s_x_cod_provincia" id="s_x_cod_provincia" value="<?php echo $frl_celula->cod_provincia->LookupFilterQuery() ?>">
</span>
<?php echo $frl_celula->cod_provincia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_celula->cod_distrito->Visible) { // cod_distrito ?>
	<div id="r_cod_distrito" class="form-group">
		<label id="elh_frl_celula_cod_distrito" for="x_cod_distrito" class="col-sm-2 control-label ewLabel"><?php echo $frl_celula->cod_distrito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_celula->cod_distrito->CellAttributes() ?>>
<span id="el_frl_celula_cod_distrito">
<?php $frl_celula->cod_distrito->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$frl_celula->cod_distrito->EditAttrs["onchange"]; ?>
<select data-table="frl_celula" data-field="x_cod_distrito" data-value-separator="<?php echo $frl_celula->cod_distrito->DisplayValueSeparatorAttribute() ?>" id="x_cod_distrito" name="x_cod_distrito"<?php echo $frl_celula->cod_distrito->EditAttributes() ?>>
<?php echo $frl_celula->cod_distrito->SelectOptionListHtml("x_cod_distrito") ?>
</select>
<input type="hidden" name="s_x_cod_distrito" id="s_x_cod_distrito" value="<?php echo $frl_celula->cod_distrito->LookupFilterQuery() ?>">
</span>
<?php echo $frl_celula->cod_distrito->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_celula->cod_zona->Visible) { // cod_zona ?>
	<div id="r_cod_zona" class="form-group">
		<label id="elh_frl_celula_cod_zona" for="x_cod_zona" class="col-sm-2 control-label ewLabel"><?php echo $frl_celula->cod_zona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_celula->cod_zona->CellAttributes() ?>>
<span id="el_frl_celula_cod_zona">
<?php $frl_celula->cod_zona->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$frl_celula->cod_zona->EditAttrs["onchange"]; ?>
<select data-table="frl_celula" data-field="x_cod_zona" data-value-separator="<?php echo $frl_celula->cod_zona->DisplayValueSeparatorAttribute() ?>" id="x_cod_zona" name="x_cod_zona"<?php echo $frl_celula->cod_zona->EditAttributes() ?>>
<?php echo $frl_celula->cod_zona->SelectOptionListHtml("x_cod_zona") ?>
</select>
<input type="hidden" name="s_x_cod_zona" id="s_x_cod_zona" value="<?php echo $frl_celula->cod_zona->LookupFilterQuery() ?>">
</span>
<?php echo $frl_celula->cod_zona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_celula->cod_circulo->Visible) { // cod_circulo ?>
	<div id="r_cod_circulo" class="form-group">
		<label id="elh_frl_celula_cod_circulo" for="x_cod_circulo" class="col-sm-2 control-label ewLabel"><?php echo $frl_celula->cod_circulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_celula->cod_circulo->CellAttributes() ?>>
<span id="el_frl_celula_cod_circulo">
<select data-table="frl_celula" data-field="x_cod_circulo" data-value-separator="<?php echo $frl_celula->cod_circulo->DisplayValueSeparatorAttribute() ?>" id="x_cod_circulo" name="x_cod_circulo"<?php echo $frl_celula->cod_circulo->EditAttributes() ?>>
<?php echo $frl_celula->cod_circulo->SelectOptionListHtml("x_cod_circulo") ?>
</select>
<input type="hidden" name="s_x_cod_circulo" id="s_x_cod_circulo" value="<?php echo $frl_celula->cod_circulo->LookupFilterQuery() ?>">
</span>
<?php echo $frl_celula->cod_circulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$frl_celula_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $frl_celula_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ffrl_celulaedit.Init();
</script>
<?php
$frl_celula_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$frl_celula_edit->Page_Terminate();
?>