<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "sms_postos_administrativosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$sms_postos_administrativos_edit = NULL; // Initialize page object first

class csms_postos_administrativos_edit extends csms_postos_administrativos {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{286C4D49-9D44-49E9-A580-A7321FF88E9C}";

	// Table name
	var $TableName = 'sms_postos_administrativos';

	// Page object name
	var $PageObjName = 'sms_postos_administrativos_edit';

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

		// Table object (sms_postos_administrativos)
		if (!isset($GLOBALS["sms_postos_administrativos"]) || get_class($GLOBALS["sms_postos_administrativos"]) == "csms_postos_administrativos") {
			$GLOBALS["sms_postos_administrativos"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["sms_postos_administrativos"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'sms_postos_administrativos', TRUE);

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
		$this->sms_pos_id->SetVisibility();
		$this->sms_pos_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->posto_administrativo->SetVisibility();
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
		global $EW_EXPORT, $sms_postos_administrativos;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($sms_postos_administrativos);
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
		if (@$_GET["sms_pos_id"] <> "") {
			$this->sms_pos_id->setQueryStringValue($_GET["sms_pos_id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->sms_pos_id->CurrentValue == "") {
			$this->Page_Terminate("sms_postos_administrativoslist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("sms_postos_administrativoslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "sms_postos_administrativoslist.php")
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
		if (!$this->sms_pos_id->FldIsDetailKey)
			$this->sms_pos_id->setFormValue($objForm->GetValue("x_sms_pos_id"));
		if (!$this->posto_administrativo->FldIsDetailKey) {
			$this->posto_administrativo->setFormValue($objForm->GetValue("x_posto_administrativo"));
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
		$this->LoadRow();
		$this->sms_pos_id->CurrentValue = $this->sms_pos_id->FormValue;
		$this->posto_administrativo->CurrentValue = $this->posto_administrativo->FormValue;
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
		$this->sms_pos_id->setDbValue($rs->fields('sms_pos_id'));
		$this->posto_administrativo->setDbValue($rs->fields('posto_administrativo'));
		$this->cod_provincia->setDbValue($rs->fields('cod_provincia'));
		$this->cod_distrito->setDbValue($rs->fields('cod_distrito'));
		$this->populacao->setDbValue($rs->fields('populacao'));
		$this->eleitores->setDbValue($rs->fields('eleitores'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->sms_pos_id->DbValue = $row['sms_pos_id'];
		$this->posto_administrativo->DbValue = $row['posto_administrativo'];
		$this->cod_provincia->DbValue = $row['cod_provincia'];
		$this->cod_distrito->DbValue = $row['cod_distrito'];
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
		// sms_pos_id
		// posto_administrativo
		// cod_provincia
		// cod_distrito
		// populacao
		// eleitores

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// sms_pos_id
		$this->sms_pos_id->ViewValue = $this->sms_pos_id->CurrentValue;
		$this->sms_pos_id->ViewCustomAttributes = "";

		// posto_administrativo
		$this->posto_administrativo->ViewValue = $this->posto_administrativo->CurrentValue;
		$this->posto_administrativo->ViewCustomAttributes = "";

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

			// sms_pos_id
			$this->sms_pos_id->LinkCustomAttributes = "";
			$this->sms_pos_id->HrefValue = "";
			$this->sms_pos_id->TooltipValue = "";

			// posto_administrativo
			$this->posto_administrativo->LinkCustomAttributes = "";
			$this->posto_administrativo->HrefValue = "";
			$this->posto_administrativo->TooltipValue = "";

			// cod_provincia
			$this->cod_provincia->LinkCustomAttributes = "";
			$this->cod_provincia->HrefValue = "";
			$this->cod_provincia->TooltipValue = "";

			// cod_distrito
			$this->cod_distrito->LinkCustomAttributes = "";
			$this->cod_distrito->HrefValue = "";
			$this->cod_distrito->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// sms_pos_id
			$this->sms_pos_id->EditAttrs["class"] = "form-control";
			$this->sms_pos_id->EditCustomAttributes = "";
			$this->sms_pos_id->EditValue = $this->sms_pos_id->CurrentValue;
			$this->sms_pos_id->ViewCustomAttributes = "";

			// posto_administrativo
			$this->posto_administrativo->EditAttrs["class"] = "form-control";
			$this->posto_administrativo->EditCustomAttributes = "";
			$this->posto_administrativo->EditValue = ew_HtmlEncode($this->posto_administrativo->CurrentValue);
			$this->posto_administrativo->PlaceHolder = ew_RemoveHtml($this->posto_administrativo->FldCaption());

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

			// Edit refer script
			// sms_pos_id

			$this->sms_pos_id->LinkCustomAttributes = "";
			$this->sms_pos_id->HrefValue = "";

			// posto_administrativo
			$this->posto_administrativo->LinkCustomAttributes = "";
			$this->posto_administrativo->HrefValue = "";

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
		if (!$this->posto_administrativo->FldIsDetailKey && !is_null($this->posto_administrativo->FormValue) && $this->posto_administrativo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->posto_administrativo->FldCaption(), $this->posto_administrativo->ReqErrMsg));
		}
		if (!$this->cod_provincia->FldIsDetailKey && !is_null($this->cod_provincia->FormValue) && $this->cod_provincia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cod_provincia->FldCaption(), $this->cod_provincia->ReqErrMsg));
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

			// posto_administrativo
			$this->posto_administrativo->SetDbValueDef($rsnew, $this->posto_administrativo->CurrentValue, "", $this->posto_administrativo->ReadOnly);

			// cod_provincia
			$this->cod_provincia->SetDbValueDef($rsnew, $this->cod_provincia->CurrentValue, 0, $this->cod_provincia->ReadOnly);

			// cod_distrito
			$this->cod_distrito->SetDbValueDef($rsnew, $this->cod_distrito->CurrentValue, NULL, $this->cod_distrito->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("sms_postos_administrativoslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($sms_postos_administrativos_edit)) $sms_postos_administrativos_edit = new csms_postos_administrativos_edit();

// Page init
$sms_postos_administrativos_edit->Page_Init();

// Page main
$sms_postos_administrativos_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sms_postos_administrativos_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fsms_postos_administrativosedit = new ew_Form("fsms_postos_administrativosedit", "edit");

// Validate form
fsms_postos_administrativosedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_posto_administrativo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sms_postos_administrativos->posto_administrativo->FldCaption(), $sms_postos_administrativos->posto_administrativo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cod_provincia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sms_postos_administrativos->cod_provincia->FldCaption(), $sms_postos_administrativos->cod_provincia->ReqErrMsg)) ?>");

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
fsms_postos_administrativosedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsms_postos_administrativosedit.ValidateRequired = true;
<?php } else { ?>
fsms_postos_administrativosedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsms_postos_administrativosedit.Lists["x_cod_provincia"] = {"LinkField":"x_sms_pro_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_provincia","","",""],"ParentFields":[],"ChildFields":["x_cod_distrito"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sms_provincias"};
fsms_postos_administrativosedit.Lists["x_cod_distrito"] = {"LinkField":"x_sms_dis_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_distrito","","",""],"ParentFields":["x_cod_provincia"],"ChildFields":[],"FilterFields":["x_cod_provincia"],"Options":[],"Template":"","LinkTable":"sms_distritos"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$sms_postos_administrativos_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $sms_postos_administrativos_edit->ShowPageHeader(); ?>
<?php
$sms_postos_administrativos_edit->ShowMessage();
?>
<form name="fsms_postos_administrativosedit" id="fsms_postos_administrativosedit" class="<?php echo $sms_postos_administrativos_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($sms_postos_administrativos_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $sms_postos_administrativos_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="sms_postos_administrativos">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($sms_postos_administrativos_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($sms_postos_administrativos->sms_pos_id->Visible) { // sms_pos_id ?>
	<div id="r_sms_pos_id" class="form-group">
		<label id="elh_sms_postos_administrativos_sms_pos_id" class="col-sm-2 control-label ewLabel"><?php echo $sms_postos_administrativos->sms_pos_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $sms_postos_administrativos->sms_pos_id->CellAttributes() ?>>
<span id="el_sms_postos_administrativos_sms_pos_id">
<span<?php echo $sms_postos_administrativos->sms_pos_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sms_postos_administrativos->sms_pos_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="sms_postos_administrativos" data-field="x_sms_pos_id" name="x_sms_pos_id" id="x_sms_pos_id" value="<?php echo ew_HtmlEncode($sms_postos_administrativos->sms_pos_id->CurrentValue) ?>">
<?php echo $sms_postos_administrativos->sms_pos_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sms_postos_administrativos->posto_administrativo->Visible) { // posto_administrativo ?>
	<div id="r_posto_administrativo" class="form-group">
		<label id="elh_sms_postos_administrativos_posto_administrativo" for="x_posto_administrativo" class="col-sm-2 control-label ewLabel"><?php echo $sms_postos_administrativos->posto_administrativo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $sms_postos_administrativos->posto_administrativo->CellAttributes() ?>>
<span id="el_sms_postos_administrativos_posto_administrativo">
<input type="text" data-table="sms_postos_administrativos" data-field="x_posto_administrativo" name="x_posto_administrativo" id="x_posto_administrativo" size="30" maxlength="40" placeholder="<?php echo ew_HtmlEncode($sms_postos_administrativos->posto_administrativo->getPlaceHolder()) ?>" value="<?php echo $sms_postos_administrativos->posto_administrativo->EditValue ?>"<?php echo $sms_postos_administrativos->posto_administrativo->EditAttributes() ?>>
</span>
<?php echo $sms_postos_administrativos->posto_administrativo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sms_postos_administrativos->cod_provincia->Visible) { // cod_provincia ?>
	<div id="r_cod_provincia" class="form-group">
		<label id="elh_sms_postos_administrativos_cod_provincia" for="x_cod_provincia" class="col-sm-2 control-label ewLabel"><?php echo $sms_postos_administrativos->cod_provincia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $sms_postos_administrativos->cod_provincia->CellAttributes() ?>>
<span id="el_sms_postos_administrativos_cod_provincia">
<?php $sms_postos_administrativos->cod_provincia->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$sms_postos_administrativos->cod_provincia->EditAttrs["onchange"]; ?>
<select data-table="sms_postos_administrativos" data-field="x_cod_provincia" data-value-separator="<?php echo $sms_postos_administrativos->cod_provincia->DisplayValueSeparatorAttribute() ?>" id="x_cod_provincia" name="x_cod_provincia"<?php echo $sms_postos_administrativos->cod_provincia->EditAttributes() ?>>
<?php echo $sms_postos_administrativos->cod_provincia->SelectOptionListHtml("x_cod_provincia") ?>
</select>
<input type="hidden" name="s_x_cod_provincia" id="s_x_cod_provincia" value="<?php echo $sms_postos_administrativos->cod_provincia->LookupFilterQuery() ?>">
</span>
<?php echo $sms_postos_administrativos->cod_provincia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sms_postos_administrativos->cod_distrito->Visible) { // cod_distrito ?>
	<div id="r_cod_distrito" class="form-group">
		<label id="elh_sms_postos_administrativos_cod_distrito" for="x_cod_distrito" class="col-sm-2 control-label ewLabel"><?php echo $sms_postos_administrativos->cod_distrito->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $sms_postos_administrativos->cod_distrito->CellAttributes() ?>>
<span id="el_sms_postos_administrativos_cod_distrito">
<select data-table="sms_postos_administrativos" data-field="x_cod_distrito" data-value-separator="<?php echo $sms_postos_administrativos->cod_distrito->DisplayValueSeparatorAttribute() ?>" id="x_cod_distrito" name="x_cod_distrito"<?php echo $sms_postos_administrativos->cod_distrito->EditAttributes() ?>>
<?php echo $sms_postos_administrativos->cod_distrito->SelectOptionListHtml("x_cod_distrito") ?>
</select>
<input type="hidden" name="s_x_cod_distrito" id="s_x_cod_distrito" value="<?php echo $sms_postos_administrativos->cod_distrito->LookupFilterQuery() ?>">
</span>
<?php echo $sms_postos_administrativos->cod_distrito->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$sms_postos_administrativos_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $sms_postos_administrativos_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fsms_postos_administrativosedit.Init();
</script>
<?php
$sms_postos_administrativos_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$sms_postos_administrativos_edit->Page_Terminate();
?>
