<?php

// Global variable for table object
$frl_celula = NULL;

//
// Table class for frl_celula
//
class cfrl_celula extends cTable {
	var $frl_cel_id;
	var $celula;
	var $cod_provincia;
	var $cod_distrito;
	var $cod_zona;
	var $cod_circulo;
	var $populacao;
	var $eleitores;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'frl_celula';
		$this->TableName = 'frl_celula';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`frl_celula`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// frl_cel_id
		$this->frl_cel_id = new cField('frl_celula', 'frl_celula', 'x_frl_cel_id', 'frl_cel_id', '`frl_cel_id`', '`frl_cel_id`', 3, -1, FALSE, '`frl_cel_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->frl_cel_id->Sortable = TRUE; // Allow sort
		$this->frl_cel_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['frl_cel_id'] = &$this->frl_cel_id;

		// celula
		$this->celula = new cField('frl_celula', 'frl_celula', 'x_celula', 'celula', '`celula`', '`celula`', 200, -1, FALSE, '`celula`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->celula->Sortable = TRUE; // Allow sort
		$this->fields['celula'] = &$this->celula;

		// cod_provincia
		$this->cod_provincia = new cField('frl_celula', 'frl_celula', 'x_cod_provincia', 'cod_provincia', '`cod_provincia`', '`cod_provincia`', 3, -1, FALSE, '`cod_provincia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->cod_provincia->Sortable = TRUE; // Allow sort
		$this->cod_provincia->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->cod_provincia->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->cod_provincia->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_provincia'] = &$this->cod_provincia;

		// cod_distrito
		$this->cod_distrito = new cField('frl_celula', 'frl_celula', 'x_cod_distrito', 'cod_distrito', '`cod_distrito`', '`cod_distrito`', 3, -1, FALSE, '`cod_distrito`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->cod_distrito->Sortable = TRUE; // Allow sort
		$this->cod_distrito->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->cod_distrito->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->cod_distrito->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_distrito'] = &$this->cod_distrito;

		// cod_zona
		$this->cod_zona = new cField('frl_celula', 'frl_celula', 'x_cod_zona', 'cod_zona', '`cod_zona`', '`cod_zona`', 3, -1, FALSE, '`cod_zona`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->cod_zona->Sortable = TRUE; // Allow sort
		$this->cod_zona->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->cod_zona->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->cod_zona->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_zona'] = &$this->cod_zona;

		// cod_circulo
		$this->cod_circulo = new cField('frl_celula', 'frl_celula', 'x_cod_circulo', 'cod_circulo', '`cod_circulo`', '`cod_circulo`', 3, -1, FALSE, '`cod_circulo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->cod_circulo->Sortable = TRUE; // Allow sort
		$this->cod_circulo->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->cod_circulo->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->cod_circulo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cod_circulo'] = &$this->cod_circulo;

		// populacao
		$this->populacao = new cField('frl_celula', 'frl_celula', 'x_populacao', 'populacao', '`populacao`', '`populacao`', 3, -1, FALSE, '`populacao`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->populacao->Sortable = FALSE; // Allow sort
		$this->populacao->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['populacao'] = &$this->populacao;

		// eleitores
		$this->eleitores = new cField('frl_celula', 'frl_celula', 'x_eleitores', 'eleitores', '`eleitores`', '`eleitores`', 3, -1, FALSE, '`eleitores`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->eleitores->Sortable = FALSE; // Allow sort
		$this->eleitores->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['eleitores'] = &$this->eleitores;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`frl_celula`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->frl_cel_id->setDbValue($conn->Insert_ID());
			$rs['frl_cel_id'] = $this->frl_cel_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('frl_cel_id', $rs))
				ew_AddFilter($where, ew_QuotedName('frl_cel_id', $this->DBID) . '=' . ew_QuotedValue($rs['frl_cel_id'], $this->frl_cel_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`frl_cel_id` = @frl_cel_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->frl_cel_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@frl_cel_id@", ew_AdjustSql($this->frl_cel_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "frl_celulalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "frl_celulalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("frl_celulaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("frl_celulaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "frl_celulaadd.php?" . $this->UrlParm($parm);
		else
			$url = "frl_celulaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("frl_celulaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("frl_celulaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("frl_celuladelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "frl_cel_id:" . ew_VarToJson($this->frl_cel_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->frl_cel_id->CurrentValue)) {
			$sUrl .= "frl_cel_id=" . urlencode($this->frl_cel_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["frl_cel_id"]))
				$arKeys[] = ew_StripSlashes($_POST["frl_cel_id"]);
			elseif (isset($_GET["frl_cel_id"]))
				$arKeys[] = ew_StripSlashes($_GET["frl_cel_id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->frl_cel_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->frl_cel_id->setDbValue($rs->fields('frl_cel_id'));
		$this->celula->setDbValue($rs->fields('celula'));
		$this->cod_provincia->setDbValue($rs->fields('cod_provincia'));
		$this->cod_distrito->setDbValue($rs->fields('cod_distrito'));
		$this->cod_zona->setDbValue($rs->fields('cod_zona'));
		$this->cod_circulo->setDbValue($rs->fields('cod_circulo'));
		$this->populacao->setDbValue($rs->fields('populacao'));
		$this->eleitores->setDbValue($rs->fields('eleitores'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// frl_cel_id
		// celula
		// cod_provincia
		// cod_distrito
		// cod_zona
		// cod_circulo
		// populacao

		$this->populacao->CellCssStyle = "white-space: nowrap;";

		// eleitores
		$this->eleitores->CellCssStyle = "white-space: nowrap;";

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

		// populacao
		$this->populacao->ViewValue = $this->populacao->CurrentValue;
		$this->populacao->ViewCustomAttributes = "";

		// eleitores
		$this->eleitores->ViewValue = $this->eleitores->CurrentValue;
		$this->eleitores->ViewCustomAttributes = "";

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

		// populacao
		$this->populacao->LinkCustomAttributes = "";
		$this->populacao->HrefValue = "";
		$this->populacao->TooltipValue = "";

		// eleitores
		$this->eleitores->LinkCustomAttributes = "";
		$this->eleitores->HrefValue = "";
		$this->eleitores->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// frl_cel_id
		$this->frl_cel_id->EditAttrs["class"] = "form-control";
		$this->frl_cel_id->EditCustomAttributes = "";
		$this->frl_cel_id->EditValue = $this->frl_cel_id->CurrentValue;
		$this->frl_cel_id->ViewCustomAttributes = "";

		// celula
		$this->celula->EditAttrs["class"] = "form-control";
		$this->celula->EditCustomAttributes = "";
		$this->celula->EditValue = $this->celula->CurrentValue;
		$this->celula->PlaceHolder = ew_RemoveHtml($this->celula->FldCaption());

		// cod_provincia
		$this->cod_provincia->EditAttrs["class"] = "form-control";
		$this->cod_provincia->EditCustomAttributes = "";

		// cod_distrito
		$this->cod_distrito->EditAttrs["class"] = "form-control";
		$this->cod_distrito->EditCustomAttributes = "";

		// cod_zona
		$this->cod_zona->EditAttrs["class"] = "form-control";
		$this->cod_zona->EditCustomAttributes = "";

		// cod_circulo
		$this->cod_circulo->EditAttrs["class"] = "form-control";
		$this->cod_circulo->EditCustomAttributes = "";

		// populacao
		$this->populacao->EditAttrs["class"] = "form-control";
		$this->populacao->EditCustomAttributes = "";
		$this->populacao->EditValue = $this->populacao->CurrentValue;
		$this->populacao->PlaceHolder = ew_RemoveHtml($this->populacao->FldCaption());

		// eleitores
		$this->eleitores->EditAttrs["class"] = "form-control";
		$this->eleitores->EditCustomAttributes = "";
		$this->eleitores->EditValue = $this->eleitores->CurrentValue;
		$this->eleitores->PlaceHolder = ew_RemoveHtml($this->eleitores->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->frl_cel_id->Exportable) $Doc->ExportCaption($this->frl_cel_id);
					if ($this->celula->Exportable) $Doc->ExportCaption($this->celula);
					if ($this->cod_provincia->Exportable) $Doc->ExportCaption($this->cod_provincia);
					if ($this->cod_distrito->Exportable) $Doc->ExportCaption($this->cod_distrito);
					if ($this->cod_zona->Exportable) $Doc->ExportCaption($this->cod_zona);
					if ($this->cod_circulo->Exportable) $Doc->ExportCaption($this->cod_circulo);
				} else {
					if ($this->frl_cel_id->Exportable) $Doc->ExportCaption($this->frl_cel_id);
					if ($this->celula->Exportable) $Doc->ExportCaption($this->celula);
					if ($this->cod_provincia->Exportable) $Doc->ExportCaption($this->cod_provincia);
					if ($this->cod_distrito->Exportable) $Doc->ExportCaption($this->cod_distrito);
					if ($this->cod_zona->Exportable) $Doc->ExportCaption($this->cod_zona);
					if ($this->cod_circulo->Exportable) $Doc->ExportCaption($this->cod_circulo);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->frl_cel_id->Exportable) $Doc->ExportField($this->frl_cel_id);
						if ($this->celula->Exportable) $Doc->ExportField($this->celula);
						if ($this->cod_provincia->Exportable) $Doc->ExportField($this->cod_provincia);
						if ($this->cod_distrito->Exportable) $Doc->ExportField($this->cod_distrito);
						if ($this->cod_zona->Exportable) $Doc->ExportField($this->cod_zona);
						if ($this->cod_circulo->Exportable) $Doc->ExportField($this->cod_circulo);
					} else {
						if ($this->frl_cel_id->Exportable) $Doc->ExportField($this->frl_cel_id);
						if ($this->celula->Exportable) $Doc->ExportField($this->celula);
						if ($this->cod_provincia->Exportable) $Doc->ExportField($this->cod_provincia);
						if ($this->cod_distrito->Exportable) $Doc->ExportField($this->cod_distrito);
						if ($this->cod_zona->Exportable) $Doc->ExportField($this->cod_zona);
						if ($this->cod_circulo->Exportable) $Doc->ExportField($this->cod_circulo);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
