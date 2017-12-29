<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "frl_zonainfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$frl_zona_add = NULL; // Initialize page object first

class cfrl_zona_add extends cfrl_zona {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{286C4D49-9D44-49E9-A580-A7321FF88E9C}";

	// Table name
	var $TableName = 'frl_zona';

	// Page object name
	var $PageObjName = 'frl_zona_add';

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

		// Table object (frl_zona)
		if (!isset($GLOBALS["frl_zona"]) || get_class($GLOBALS["frl_zona"]) == "cfrl_zona") {
			$GLOBALS["frl_zona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["frl_zona"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'frl_zona', TRUE);

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
		$this->zona->SetVisibility();
		$this->cod_provincia->SetVisibility();
		$this->cod_distrito->SetVisibility();

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
		global $EW_EXPORT, $frl_zona;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($frl_zona);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["frl_zon_id"] != "") {
				$this->frl_zon_id->setQueryStringValue($_GET["frl_zon_id"]);
				$this->setKey("frl_zon_id", $this->frl_zon_id->CurrentValue); // Set up key
			} else {
				$this->setKey("frl_zon_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("frl_zonalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "frl_zonalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "frl_zonaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->zona->CurrentValue = NULL;
		$this->zona->OldValue = $this->zona->CurrentValue;
		$this->cod_provincia->CurrentValue = NULL;
		$this->cod_provincia->OldValue = $this->cod_provincia->CurrentValue;
		$this->cod_distrito->CurrentValue = NULL;
		$this->cod_distrito->OldValue = $this->cod_distrito->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->zona->FldIsDetailKey) {
			$this->zona->setFormValue($objForm->GetValue("x_zona"));
		}
		if (!$this->cod_provincia->FldIsDetailKey) {
			$this->cod_provincia->setFormValue($objForm->GetValue("x_cod_provincia"));
		}
		if (!$this->cod_distrito->FldIsDetailKey) {
			$this->cod_distrito->setFormValue($objForm->GetValue("x_cod_distrito"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->zona->CurrentValue = $this->zona->FormValue;
		$this->cod_provincia->CurrentValue = $this->cod_provincia->FormValue;
		$this->cod_distrito->CurrentValue = $this->cod_distrito->FormValue;
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
		$this->frl_zon_id->setDbValue($rs->fields('frl_zon_id'));
		$this->zona->setDbValue($rs->fields('zona'));
		$this->cod_provincia->setDbValue($rs->fields('cod_provincia'));
		$this->cod_distrito->setDbValue($rs->fields('cod_distrito'));
		$this->populacao->setDbValue($rs->fields('populacao'));
		$this->eleitores->setDbValue($rs->fields('eleitores'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->frl_zon_id->DbValue = $row['frl_zon_id'];
		$this->zona->DbValue = $row['zona'];
		$this->cod_provincia->DbValue = $row['cod_provincia'];
		$this->cod_distrito->DbValue = $row['cod_distrito'];
		$this->populacao->DbValue = $row['populacao'];
		$this->eleitores->DbValue = $row['eleitores'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("frl_zon_id")) <> "")
			$this->frl_zon_id->CurrentValue = $this->getKey("frl_zon_id"); // frl_zon_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// frl_zon_id
		// zona
		// cod_provincia
		// cod_distrito
		// populacao
		// eleitores

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// frl_zon_id
		$this->frl_zon_id->ViewValue = $this->frl_zon_id->CurrentValue;
		$this->frl_zon_id->ViewCustomAttributes = "";

		// zona
		$this->zona->ViewValue = $this->zona->CurrentValue;
		$this->zona->ViewCustomAttributes = "";

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

			// zona
			$this->zona->LinkCustomAttributes = "";
			$this->zona->HrefValue = "";
			$this->zona->TooltipValue = "";

			// cod_provincia
			$this->cod_provincia->LinkCustomAttributes = "";
			$this->cod_provincia->HrefValue = "";
			$this->cod_provincia->TooltipValue = "";

			// cod_distrito
			$this->cod_distrito->LinkCustomAttributes = "";
			$this->cod_distrito->HrefValue = "";
			$this->cod_distrito->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// zona
			$this->zona->EditAttrs["class"] = "form-control";
			$this->zona->EditCustomAttributes = "";
			$this->zona->EditValue = ew_HtmlEncode($this->zona->CurrentValue);
			$this->zona->PlaceHolder = ew_RemoveHtml($this->zona->FldCaption());

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

			// Add refer script
			// zona

			$this->zona->LinkCustomAttributes = "";
			$this->zona->HrefValue = "";

			// cod_provincia
			$this->cod_provincia->LinkCustomAttributes = "";
			$this->cod_provincia->HrefValue = "";

			// cod_distrito
			$this->cod_distrito->LinkCustomAttributes = "";
			$this->cod_distrito->HrefValue = "";
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
		if (!$this->zona->FldIsDetailKey && !is_null($this->zona->FormValue) && $this->zona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->zona->FldCaption(), $this->zona->ReqErrMsg));
		}
		if (!$this->cod_provincia->FldIsDetailKey && !is_null($this->cod_provincia->FormValue) && $this->cod_provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_provincia->FldCaption(), $this->cod_provincia->ReqErrMsg));
		}
		if (!$this->cod_distrito->FldIsDetailKey && !is_null($this->cod_distrito->FormValue) && $this->cod_distrito->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_distrito->FldCaption(), $this->cod_distrito->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// zona
		$this->zona->SetDbValueDef($rsnew, $this->zona->CurrentValue, "", FALSE);

		// cod_provincia
		$this->cod_provincia->SetDbValueDef($rsnew, $this->cod_provincia->CurrentValue, 0, FALSE);

		// cod_distrito
		$this->cod_distrito->SetDbValueDef($rsnew, $this->cod_distrito->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("frl_zonalist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($frl_zona_add)) $frl_zona_add = new cfrl_zona_add();

// Page init
$frl_zona_add->Page_Init();

// Page main
$frl_zona_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$frl_zona_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ffrl_zonaadd = new ew_Form("ffrl_zonaadd", "add");

// Validate form
ffrl_zonaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_zona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_zona->zona->FldCaption(), $frl_zona->zona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_provincia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_zona->cod_provincia->FldCaption(), $frl_zona->cod_provincia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_distrito");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $frl_zona->cod_distrito->FldCaption(), $frl_zona->cod_distrito->ReqErrMsg)) ?>");

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
ffrl_zonaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffrl_zonaadd.ValidateRequired = true;
<?php } else { ?>
ffrl_zonaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffrl_zonaadd.Lists["x_cod_provincia"] = {"LinkField":"x_sms_pro_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_provincia","","",""],"ParentFields":[],"ChildFields":["x_cod_distrito"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sms_provincias"};
ffrl_zonaadd.Lists["x_cod_distrito"] = {"LinkField":"x_sms_dis_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_distrito","","",""],"ParentFields":["x_cod_provincia"],"ChildFields":[],"FilterFields":["x_cod_provincia"],"Options":[],"Template":"","LinkTable":"sms_distritos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$frl_zona_add->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $frl_zona_add->ShowPageHeader(); ?>
<?php
$frl_zona_add->ShowMessage();
?>
<form name="ffrl_zonaadd" id="ffrl_zonaadd" class="<?php echo $frl_zona_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($frl_zona_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $frl_zona_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="frl_zona">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($frl_zona_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($frl_zona->zona->Visible) { // zona ?>
	<div id="r_zona" class="form-group">
		<label id="elh_frl_zona_zona" for="x_zona" class="col-sm-2 control-label ewLabel"><?php echo $frl_zona->zona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_zona->zona->CellAttributes() ?>>
<span id="el_frl_zona_zona">
<input type="text" data-table="frl_zona" data-field="x_zona" name="x_zona" id="x_zona" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($frl_zona->zona->getPlaceHolder()) ?>" value="<?php echo $frl_zona->zona->EditValue ?>"<?php echo $frl_zona->zona->EditAttributes() ?>>
</span>
<?php echo $frl_zona->zona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_zona->cod_provincia->Visible) { // cod_provincia ?>
	<div id="r_cod_provincia" class="form-group">
		<label id="elh_frl_zona_cod_provincia" for="x_cod_provincia" class="col-sm-2 control-label ewLabel"><?php echo $frl_zona->cod_provincia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_zona->cod_provincia->CellAttributes() ?>>
<span id="el_frl_zona_cod_provincia">
<?php $frl_zona->cod_provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$frl_zona->cod_provincia->EditAttrs["onchange"]; ?>
<select data-table="frl_zona" data-field="x_cod_provincia" data-value-separator="<?php echo $frl_zona->cod_provincia->DisplayValueSeparatorAttribute() ?>" id="x_cod_provincia" name="x_cod_provincia"<?php echo $frl_zona->cod_provincia->EditAttributes() ?>>
<?php echo $frl_zona->cod_provincia->SelectOptionListHtml("x_cod_provincia") ?>
</select>
<input type="hidden" name="s_x_cod_provincia" id="s_x_cod_provincia" value="<?php echo $frl_zona->cod_provincia->LookupFilterQuery() ?>">
</span>
<?php echo $frl_zona->cod_provincia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($frl_zona->cod_distrito->Visible) { // cod_distrito ?>
	<div id="r_cod_distrito" class="form-group">
		<label id="elh_frl_zona_cod_distrito" for="x_cod_distrito" class="col-sm-2 control-label ewLabel"><?php echo $frl_zona->cod_distrito->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $frl_zona->cod_distrito->CellAttributes() ?>>
<span id="el_frl_zona_cod_distrito">
<select data-table="frl_zona" data-field="x_cod_distrito" data-value-separator="<?php echo $frl_zona->cod_distrito->DisplayValueSeparatorAttribute() ?>" id="x_cod_distrito" name="x_cod_distrito"<?php echo $frl_zona->cod_distrito->EditAttributes() ?>>
<?php echo $frl_zona->cod_distrito->SelectOptionListHtml("x_cod_distrito") ?>
</select>
<input type="hidden" name="s_x_cod_distrito" id="s_x_cod_distrito" value="<?php echo $frl_zona->cod_distrito->LookupFilterQuery() ?>">
</span>
<?php echo $frl_zona->cod_distrito->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$frl_zona_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $frl_zona_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ffrl_zonaadd.Init();
</script>
<?php
$frl_zona_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$frl_zona_add->Page_Terminate();
?>