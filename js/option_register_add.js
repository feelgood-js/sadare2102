//옵션체계 변경 스크립트 2016-09-21 Seul
function IsOptionUse(isused, optTotalQuan) {
	if(isused==1) {
		document.getElementById('opt_div').style.display="block";
		if(document.getElementById('optType1').checked) {
			document.getElementById('optnormal_type_div').style.display="block";
		}

		if(optTotalQuan>0) {
			document.getElementById('idx_checkquantity2').checked = true;
			document.getElementById('idx_checkquantity0').style.display="none";
			document.getElementById('idx_checkquantity1').style.display="none";
			document.getElementById('idx_checkquantity_label0').style.display="none";
			document.getElementById('idx_checkquantity_label1').style.display="none";
		}
	} else {
		document.getElementById('opt_div').style.display="none";
		document.getElementById('optnormal_type_div').style.display="none";

		document.getElementById('idx_checkquantity2').checked = false;
		document.getElementById('idx_checkquantity0').style.display="block";
		document.getElementById('idx_checkquantity1').style.display="block";
		document.getElementById('idx_checkquantity_label0').style.display="block";
		document.getElementById('idx_checkquantity_label1').style.display="block";
	}

	document.getElementById('isOptChanged').value = 1;
}

function OnblurOptnum() {
	var innerText = "",
		orgOptCnt = 0,
		optCnt = 0,
		optvalTable, tableRow, cell1, cell2, cell3, i, j;

	orgOptCnt = document.getElementById('orgoptnum').value;
	optCnt = Number(document.getElementById('optnum').value);

	if(!isNaN(optCnt) && orgOptCnt==0 && optCnt>0) {
		innerText += '<TABLE cellSpacing=0 cellPadding=0 width="100%" border="0" class="baseTable" style="margin:0px;border:none">';
		innerText += '	<colgroup>';
		innerText += '	<col width="190" />';
		innerText += '	<col width="" />';
		innerText += '	</colgroup>';
		innerText += '	<tr>';
		innerText += '		<th>옵션값 설정</th>';
		innerText += '		<td style="padding:0px;border-bottom:none">';
		innerText += '			<table cellSpacing=0 cellPadding=0 width="100%" id="optvalTable">';
		innerText += '				<colgroup>';
		innerText += '					<col width="90" />';
		innerText += '					<col width="200" />';
		innerText += '					<col width="" />';
		innerText += '				</colgroup>';
		innerText += '				<tr>';
		innerText += '					<th>필수여부</th>';
		innerText += '					<th>옵션명</th>';
		innerText += '					<th>옵션값</th>';
		innerText += '				</tr>';

		for(i=1; i<=optCnt; i++) {
			innerText += '			<tr>';
			innerText += '				<td align="center"><input type="checkbox" name="ismust[]" id="ismust'+i+'" onclick="OptMust('+i+')" value='+i+' class="checkbox" style="display:inline-block;*display:inline;*zoom:1;" checked /></td>';
			innerText += '				<td align="center"><input type="text" size="30" maxlength="20" class="input text" name="opt_name[]" id="opt_name'+i+'" onblur="OnblurOptval();" /></td>';
			innerText += '				<td>';
			innerText += '					<div id="optval_div'+i+'">';
			innerText += '						<input type="hidden" class="input" value='+i+' />';
			innerText += '						<input type="hidden" class="input" id="optValCnt'+i+'" name="optValCnt[]" value="1" />';
			innerText += '						<input type="text" size="50" maxlength="50" class="input text" name="opt_value[]" id="opt_value'+i+'_1" onblur="OnblurOptval();" />';
			innerText += '						<a href=\'javascript:OptConMod("add", '+i+');\'><span class="button" />추가+</span></a>';
			innerText += '						<a href=\'javascript:OptConMod("del", '+i+');\'><span class="button" />삭제-</span></a>';
			innerText += '					</div>';
			innerText += '				</td>';
			innerText += '			</tr>';
		}

		innerText += '			</table>';
		innerText += '		</TD>';
		innerText += '	</tr>';
		innerText += '</TABLE>';
		innerText += '<div id="optcom_div"></div>';

		document.getElementById('optatt_div').innerHTML=innerText;
	} else if (orgOptCnt!=optCnt){
		optvalTable = document.getElementById('optvalTable');

		if(orgOptCnt<optCnt) {
			for(i=orgOptCnt; i<optCnt; i++) {
				j = Number(i)+1;
				tableRow = optvalTable.insertRow(optvalTable.rows.length);
				cell1 = tableRow.insertCell(0);
				cell2 = tableRow.insertCell(1);
				cell3 = tableRow.insertCell(2);

				/*
				cell1.className = "td_con0";
				cell2.className = "td_con1";
				cell3.className = "td_con1";
				*/

				cell1.align = "center";
				cell2.align = "center";

				cell1.innerHTML = '<input type="checkbox" name="ismust[]" id="ismust'+j+'" class="checkbox" style="display:inline-block;*display:inline;*zoom:1;" onclick="OptMust('+j+')" value='+j+' checked />';
				cell2.innerHTML = '<input type="text" size="30" maxlength="20" class="input text" name="opt_name[]" id="opt_name'+j+'" onblur="OnblurOptval();" />';
				innerText += '<div id="optval_div'+j+'">';
				innerText += '	<input type="hidden" class="input" value='+j+' />';
				innerText += '	<input type="hidden" class="input" id="optValCnt'+j+'" name="optValCnt[]" value="1" />';
				innerText += '	<input type="text" size="50" maxlength="50" class="input text" name="opt_value[]" id="opt_value'+j+'_1" onblur="OnblurOptval();">';
				innerText += '	<a href=\'javascript:OptConMod("add", '+j+');\'><span class="button" />추가+</span></a>';
				innerText += '	<a href=\'javascript:OptConMod("del", '+j+');\'><span class="button" />삭제-</span></a>';
				innerText += '</div>';
				cell3.innerHTML = innerText;

				innerText = "";
			}
		} else if(orgOptCnt>optCnt) {
			if(optCnt<=0) {
				alert("옵션 개수는 1개 이상이여야 합니다");
				document.getElementById('optnum').value = orgOptCnt;
				return;
			} else {
				for(i=optCnt; i<orgOptCnt; i++) {
					optvalTable.deleteRow(optvalTable.rows.length - 1);
				}
			}
		}
	}
	OnblurOptval();
	document.getElementById('orgoptnum').value = optCnt;

	document.getElementById('isOptChanged').value = 1;
}

function OptMust(num) {
	var optType = document.getElementById('optType1');

	if(optType.checked) {
		document.getElementById('ismust'+num).checked = true;
		alert('일반형 옵션은 모든 옵션값이 무조건 필수입니다.');
	}

	document.getElementById('isOptChanged').value = 1;
}

function OptConMod(mode, num) {
	var innerText = "",
		optValCnt = document.getElementById('optValCnt'+num).value,
		optValEl  = document.getElementById('optVal'+num+'_'+optValCnt);

	if(mode=="add") {
		optValCnt++;
		innerText += '							<div id="optVal'+num+'_'+optValCnt+'" style="margin-top:5px;">';
		innerText += '								<input type="text" size="50" maxlength="50" class="input text" name="opt_value[]" id="opt_value'+num+'_'+optValCnt+'" onblur="OnblurOptval();">';
		//innerText += '								<a href=\'javascript:OptConMod("del", '+num+');\'><span style="margin-left:5px; ">삭제-</span></a>';
		innerText += '							</div>';
		//document.getElementById('optval_div'+num).appendChild("들어옴");
		//document.getElementById().innerHTML += innerText;
		jQuery('#'+'optval_div'+num).append(innerText);

		document.getElementById('optValCnt'+num).value = optValCnt;
		OnblurOptval();
	} else if(mode=="del") {
		if(optValCnt==1) {
			alert('옵션값을 더이상 삭제 할 수 없습니다.');
		} else {
			optValEl.parentNode.removeChild(optValEl);

			optValCnt--;
			document.getElementById('optValCnt'+num).value = optValCnt;

			OnblurOptval();
		}
	}

	document.getElementById('isOptChanged').value = 1;
}

function OnblurOptval() {
	var optCnt = document.getElementById('optnum').value,
		optValCnt = 0,
		optValTotalCnt = 0;
		i = 1,
		j = 1,
		isNotfull = false,
		arrOptvalCnt = new Array(),
		arrOptvalIdx = new Array(),
		arrOptComLim = new Array(),
		arrOptComAdd = new Array(),
		optComCnt = 1,
		divisionNum = new Array();

	for(i=1; i<=optCnt; i++) {
		if(document.getElementById('opt_name'+i).value=="") {
			isNotfull = true;
			break;
		} else {
			optValCnt = document.getElementById('optValCnt'+i).value;
			optValTotalCnt += Number(optValCnt);
			optComCnt *= optValCnt; //옵션 조합 경우의수
			arrOptvalCnt[i-1] = optValCnt;
			arrOptvalIdx[i-1] = 1;
			arrOptComLim[i-1] = optValCnt;

			if(i==1) {
				arrOptComAdd[i-1] = Number(optValCnt);
			} else {
				arrOptComAdd[i-1] = Number(arrOptComAdd[i-2]) + Number(optValCnt);
			}

			for(j=1; j<=optValCnt; j++) {
				if(document.getElementById('opt_value'+i+'_'+j).value=="") {
					isNotfull = true;
					break;
				}
			}

			if(isNotfull) {
				break;
			}
		}
	}

	//다 채워졌을 때
	if(!isNotfull && optCnt>0) {
		for(i=0; i<optCnt; i++) {
			divisionNum[i] = 1;
			if(i>0) {
				for(j=0; j<i; j++) {
					divisionNum[i] *= arrOptComLim[j];
				}
			}

			//alert(divisionNum[i]);
		}

		for(i=0; i<optCnt; i++) {
			//alert(divisionNum[i]*arrOptComLim[i]);
			arrOptComLim[i] = optComCnt / (divisionNum[i]*arrOptComLim[i]);
		}

		//alert(optValTotalCnt);
		if(jQuery("input[name=optType]:checked").val()==1) {
			NormalOpt(optComCnt, optCnt, arrOptvalIdx, arrOptvalCnt, arrOptComLim, arrOptComAdd);
		} else {
			IndiOpt(optCnt, optValTotalCnt);
		}
	} else {
		document.getElementById('optcom_div').innerHTML = "";
	}

	document.getElementById('isOptChanged').value = 1;
}

//일반형 옵션 옵션재고
function NormalOpt(optComCnt, optCnt, arrOptvalIdx, arrOptvalCnt, arrOptComLim, arrOptComAdd) {
	var i = 1,
		j = 1,
		innerText = "",
		lastIdx = optCnt-1,
		combiText = "";

	//옵션 조합 배열생성
	innerText += '<TABLE cellSpacing=0 cellPadding=0 width="100%" border="0" class="baseTable" style="border:none">';
	innerText += '	<colgroup>';
	innerText += '		<col width="190" />';
	innerText += '		<col width="">';
	innerText += '	</colgroup>';
	innerText += '	<tr>';
	innerText += '		<th>옵션재고 설정</th>';
	innerText += '		<td style="padding:0px;border-bottom:none">';
	innerText += '		<table cellSpacing=0 cellPadding=0 width="100%" class="baseTable" style="border:none">';
	innerText += '			<colgroup>';
	//innerText += '			<col width=40></col>';
	innerText += '				<col width="90" />';
	innerText += '				<col width="" />';
	innerText += '				<col width="200" />';
	innerText += '				<col width="200" />';
	innerText += '				<col width="200" />';
	innerText += '			</colgroup>';
	innerText += '			<tr>';
	//innerText += '			<TD class="table_cell" align="center"><input type="checkbox"></TD>';
	innerText += '				<th>번호</th>';
	innerText += '				<th>';
	for(i=1; i<=optCnt; i++) {
		innerText += '				'+document.getElementById('opt_name'+i).value;
		if(i!=optCnt) {
			innerText += ' / ';
		}
	}
	innerText += '				</th>';
	innerText += '				<th>옵션가</th>';
	innerText += '				<th>재고량</th>';
	innerText += '				<th><label><input type="checkbox" name="opt_quan_unlimit" id="opt_quan_unlimit0" class="checkbox" style="display:inline-block;*display:inline;*zoom:1;" onclick="OptQuanUnlimit(0)" />무제한 재고 설정</label></th>';
	innerText += '			</tr>';

	for(i=0; i<optComCnt; i++) {
		combiText = "";
		innerText += '			<tr>';
		//innerText += '			<TD class="td_con0" align="center"><input type="checkbox"></TD>';
		innerText += '				<td align="center">'+(i+1)+'</TD>';

		innerText += '				<td align="center">';
		for(j=0; j<optCnt; j++) {
			//innerText += arrOptComLim[j];
			//alert((j+1)+"변경전"+(i%arrOptComLim[j]));
			//alert(arrOptComLim[j]);

			if(j==lastIdx) {
				if(arrOptvalCnt[j]==arrOptvalIdx[j]) {
					arrOptvalIdx[j] = 1;
				} else if(arrOptvalCnt[j]>arrOptvalIdx[j] && i>0) {
					arrOptvalIdx[j]++;
				}
			} else {
				if(i%arrOptComLim[j]==0 && i>0) {
					arrOptvalIdx[j]++;
				}
			}

			//innerText += '					['+j+'_'+lastIdx+'_'+arrOptComLim[j]+'_'+arrOptvalIdx[j]+']';
			if(j>0 && j<lastIdx && arrOptComLim[j-1]<(arrOptComLim[j]*arrOptvalIdx[j])) {
				//innerText += '					[들어옴]';
				arrOptvalIdx[j] = 1;
			}

			//alert((j+1)+"변경후"+arrOptvalIdx[j]);
			//innerText += arrOptComLim[j];
			//innerText += '					'+(j+1)+'_'+arrOptvalIdx[j];
			innerText += '					'+document.getElementById('opt_value'+(j+1)+'_'+arrOptvalIdx[j]).value;
			if(j!=0) {
				combiText+= (Number(arrOptvalIdx[j])+Number(arrOptComAdd[j-1]));
			} else {
				combiText+= Number(arrOptvalIdx[j]);
			}
			if(j!=optCnt-1) {
				innerText += ' / ';
				combiText+= ",";
			}

		}
		innerText += '				<input type="hidden" name="opt_com[]" value="'+combiText+'" />';
		innerText += '				</TD>';

		innerText += '				<td align="center"><input type="text" class="input text" name="opt_price[]" id="opt_price'+(i+1)+'" onblur="OnblurOptprice('+(i+1)+');" value="0" />원</TD>';
		innerText += '				<td align="center"><input type="text" class="input text" name="opt_quantity[]" id="opt_quantity'+(i+1)+'" value="0" />개</TD>';
		innerText += '				<td align="center"><label><input type="checkbox" name="opt_quan_unlimit" id="opt_quan_unlimit'+(i+1)+'" class="checkbox" style="display:inline-block;*display:inline;*zoom:1;" onclick="OptQuanUnlimit('+(i+1)+')" /> 재고 무제한</label></TD>';
		innerText += '			</tr>';
	}

	//innerText += '			<tr>';
	//innerText += '				<TD class="td_con0" colspan="6">선택 삭제</TD>';
	//innerText += '			</tr>';
	innerText += '		</table>';
	innerText += '		</TD>';
	innerText += '	</tr>';
	innerText += '</TABLE>';

	document.getElementById('optcom_div').innerHTML=innerText;

	document.getElementById('isOptChanged').value = 1;
}

//개별형 옵션 옵션재고
function IndiOpt(optCnt, optValTotalCnt) {
	var i = 1,
		j = 1,
		k = 1,
		optValCnt = 0,
		innerText = "";

	innerText += '<TABLE cellSpacing=0 cellPadding=0 width="100%" border="0" class="baseTable" style="border:none">';
	innerText += '	<colgroup>';
	innerText += '		<col width="190" />';
	innerText += '		<col width="" />';
	innerText += '	</colgroup>';
	innerText += '	<tr>';
	innerText += '		<th>옵션재고 설정</th>';
	innerText += '		<td style="padding:0px;border-bottom:none">';
	innerText += '		<table cellSpacing=0 cellPadding=0 width="100%" class="baseTable" style="border:none">';
	innerText += '			<colgroup>';
	//innerText += '			<col width=40></col>';
	innerText += '				<col width="90" />';
	innerText += '				<col width="200" />';
	innerText += '				<col width="" />';
	innerText += '				<col width="200" />';
	innerText += '				<col width="200" />';
	innerText += '				<col width="200" />';
	innerText += '			</colgroup>';
	innerText += '			<tr>';
	//innerText += '			<TD class="table_cell" align="center"><input type="checkbox"></TD>';
	innerText += '				<th>번호</th>';
	innerText += '				<th>옵션명</th>';
	innerText += '				<th>옵션값</th>';
	innerText += '				<th>옵션가</th>';
	innerText += '				<th>재고량</th>';
	innerText += '				<th><label><input type="checkbox" name="opt_quan_unlimit" id="opt_quan_unlimit0" class="checkbox" style="display:inline-block;*display:inline;*zoom:1;" onclick="OptQuanUnlimit(0)">무제한 재고 설정</label></th>';
	innerText += '			</tr>';

	for(i=1; i<=optValTotalCnt; i++) {
		if(j<=optCnt) {
			optValCnt = document.getElementById('optValCnt'+j).value;
			if(k<=optValCnt){
				innerText += '			<tr>';
				//innerText += '				<TD class="td_con0" align="center"><input type="checkbox"></TD>';
				innerText += '				<td align="center">'+i+'</td>';
				innerText += '				<td align="center">'+document.getElementById('opt_name'+j).value+'</TD>';

				innerText += '				<td align="center">';
				innerText += '					'+document.getElementById('opt_value'+j+'_'+k).value;
				innerText += '				</td>';

				innerText += '				<td align="center"><input type="text" class="input text" name="opt_price[]" id="opt_price'+i+'" onblur="OnblurOptprice('+i+');" value="0" /> 원</td>';
				innerText += '				<td align="center"><input type="text" class="input text" name="opt_quantity[]" id="opt_quantity'+i+'" value="0" /> 개</td>';
				innerText += '				<td align="center"><label><input type="checkbox" name="opt_quan_unlimit" id="opt_quan_unlimit'+i+'" onclick="OptQuanUnlimit('+i+')" class="checkbox" style="display:inline-block;*display:inline;*zoom:1;" /> 재고 무제한</label></td>';
				innerText += '			</tr>';

				k++;
			} else {
				k=1;
				j++;
				i--;
			}
		}
	}

	//innerText += '			<tr>';
	//innerText += '				<TD class="td_con0" colspan="6">선택 삭제</TD>';
	//innerText += '			</tr>';
	innerText += '		</table>';
	innerText += '		</TD>';
	innerText += '	</tr>';
	innerText += '</TABLE>';

	document.getElementById('optcom_div').innerHTML=innerText;

	document.getElementById('isOptChanged').value = 1;
}

function OnblurOptprice(idx) {
	var optPrice = Number(document.getElementById('opt_price'+idx).value),
		prdPrice = Number(document.getElementById('sellprice').value);

	if(prdPrice+optPrice<=0) {
		alert('옵션가와 판매가의 합이 0이하일경우 상품 구매를 할 수 없습니다. 다시 입력해주세요.');
		document.getElementById('opt_price'+idx).value = 0;
	}
}

function OptQuanUnlimit(idx) {
	var isCheck = document.getElementById('opt_quan_unlimit'+idx).checked;

	if(idx==0) {
		if(isCheck) {
			jQuery('input[name="opt_quantity[]"]').each(function(index, item) {
				document.getElementById('opt_quan_unlimit'+(index+1)).checked = true;
				document.getElementById('opt_quantity'+(index+1)).style.color = "#ffffff";
				document.getElementById('opt_quantity'+(index+1)).value = 9999999;
				document.getElementById('opt_quantity'+(index+1)).readOnly = true;
			});
		} else {
			jQuery('input[name="opt_quantity[]"]').each(function(index, item) {
				document.getElementById('opt_quan_unlimit'+(index+1)).checked = false;
				document.getElementById('opt_quantity'+(index+1)).style.color = "#666666";
				document.getElementById('opt_quantity'+(index+1)).value = 0;
				document.getElementById('opt_quantity'+(index+1)).readOnly = false;
			});
		}
	} else {
		if(isCheck) {
			document.getElementById('opt_quantity'+idx).style.color = "#ffffff";
			document.getElementById('opt_quantity'+idx).value = 9999999;
			document.getElementById('opt_quantity'+idx).readOnly = true;
		} else {
			document.getElementById('opt_quantity'+idx).style.color = "#666666";
			document.getElementById('opt_quantity'+idx).value = 0;
			document.getElementById('opt_quantity'+idx).readOnly = false;
		}
	}
}

function OptLoad(optData) {
	var optNum = optData.optNum,
		optType = optData.optType,
		optNormalType = optData.optNormalType,
		optTotalQuan = optData.optTotalQuan,
		arrIsMust = optData.arrIsMust,
		arrOptName = optData.arrOptName,
		arrOptLim = optData.arrOptLim,
		arrOptVal = optData.arrOptVal,
		arrOptPri = optData.arrOptPri,
		arrOptQua = optData.arrOptQua,
		i = 0,
		j = 0,
		valIdx = 0,
		arrLength = 0;

	//옵션 사용여부 사용함으로 체크
	document.getElementById('isOptUse1').checked = true;
	IsOptionUse(1, optTotalQuan);

	//옵션 유형 세팅
	document.getElementById('optType'+optType).checked = true;

	//일반형이면 옵션 유형 세팅
	if(optType==1) {
		document.getElementById('optNormalType'+optNormalType).checked = true;
	} else {
		document.getElementById('optnormal_type_div').style.display="none";
	}

	//옵션개수 세팅
	document.getElementById('optnum').value = optNum;

	//옵션값 세팅
	OnblurOptnum();
	for(i=0; i<optNum; i++) {
		if(arrIsMust[i]==0) {
			document.getElementById('ismust'+(i+1)).checked = false;
		}
		document.getElementById('opt_name'+(i+1)).value = arrOptName[i];
		for(j=0; j<arrOptLim[i]-1; j++) {
			OptConMod("add", (i+1));
		}
	}
	for(i=1; i<=optNum; i++) {
		document.getElementById('opt_name'+i).value = arrOptName[i-1];
		for(j=1; j<=arrOptLim[i-1]; j++) {
			document.getElementById('opt_value'+i+'_'+j).value = arrOptVal[valIdx];
			valIdx++;
		}
	}

	//옵션 가격, 재고 세팅
	OnblurOptval();
	arrLength = arrOptPri.length;
	for(i=0; i<arrLength; i++) {
		document.getElementById('opt_price'+(i+1)).value = arrOptPri[i];
		if(arrOptQua[i]>7999999) {
			document.getElementById('opt_quantity'+(i+1)).style.color = "#ffffff";
			document.getElementById('opt_quantity'+(i+1)).value = 9999999;
			document.getElementById('opt_quantity'+(i+1)).readOnly = true;
			document.getElementById('opt_quan_unlimit'+(i+1)).checked = true;
		} else {
			document.getElementById('opt_quantity'+(i+1)).value = arrOptQua[i];
		}
	}

	document.getElementById('isOptChanged').value = 0;
}

function ChangeOptType(optType) {
	if(optType==1) {
		document.getElementById('optnormal_type_div').style.display="block";
	} else {
		document.getElementById('optnormal_type_div').style.display="none";
	}
	OnblurOptval();

	document.getElementById('isOptChanged').value = 1;
}

function ChangeOptNormalType() {
	document.getElementById('isOptChanged').value = 1;
}
