<script language="JavaScript">
<!--
//Biblioteca JavaScript - Thiago Jabur Validação de formulários
//Põe o foco no primeiro elemento marcado com foco = true 

function abre_help(URL) {
	window.open(URL,"janela_vert","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=385,height=453,left=60,top=20'");
}	

function foco() {
 if (document.forms[0] != null) {
    	for(i = 0; i < document.forms[0].elements.length; i++) { 
	 		 elm = document.forms[0].elements[i] 
     		 if ( (elm.getAttribute("foco") == "true") )
		  		elm.focus();
       }
 }
}

function checkInt(str) {
		if (!str) return false;
			for (var i = 0; i < str.length; i++) {
				var ch = str.substring(i, i+1);
				if (ch < "0" || "9" < ch) { 
					return false;
				}					
			}
	return true;
}


function Valida(theForm)
{
    erro = 0;
    msgRequired = '';

	for(i = 0; i < theForm.elements.length; i++)
	{
    	var campo = theForm.elements[i];
     	if ( (campo.getAttribute("required") == "true") && (campo.value == "") )
		{
         if (erro == 0) { 
         		campo.focus();
         }
         msgRequired = msgRequired + campo.getAttribute("label") + "\n";		
  	     erro = 1;
		}
		
		if (campo.getAttribute("tipo") == "data") {
			 if (!checkdate(campo)) { 
	   		     return false;
   	        }
   		 }   		

		if ( (campo.getAttribute("tipo") == "inteiro") ) {		 
			if (campo.getAttribute("required") == "true") {
				if ( campo.value == "" ) {
					msgRequired = msgRequired + campo.getAttribute("label") + "\n";
					erro = 1;		
				}
			}
			if ( campo.value != "" ) {
					if (!checkInt(campo.value)) { 
			    		alert(campo.value + " não é um número inteiro válido.");
					    campo.focus();
			   		    return false;			 
   	    		    }
			} 		
		}


		if ( (campo.getAttribute("tipo") == "ano") ) {		 
			if (campo.getAttribute("required") == "true") {
				if ( campo.value == "" ) {
					msgRequired = msgRequired + campo.getAttribute("label") + "\n";
					erro = 1;		
				}
			}
			if ( campo.value != "" ) {
					if (!checkInt(campo.value)) { 
			    		alert(campo.value + " não é um ano válido.");
					    campo.focus();
			   		    return false;			 
   	    		    }
			} 		
		}



		
		if ( (campo.getAttribute("required") == "true") && (campo.getAttribute("tipo") == "combo") ) {
	   	  if (!checkcombo(campo)) {
		   	  if (erro == 0) { 
   	      			campo.focus();
         		}
         		msgRequired = msgRequired + campo.getAttribute("label") + "\n";		
  	     		erro = 1;
  	     	}
		}
       	
	}
	if (erro == "1")
   {    
   	   alert("Os seguintes campos não foram preenchidos:\n" +msgRequired)
	   return (false);
   }


   return true;
}

function checkcombo(campo)
{
 if ( campo.options.selectedIndex == 0 )
 {
  return false;
 }
 return true;
}

function checkdate(objName) {
	var datefield = objName;
	if (isDate(objName) == false) {
		datefield.select();
		datefield.focus();
		return false;
 	}
else {
		return true;
  }
}

var reDate4 = /^((0?[1-9]|[12]\d)\/(0?[1-9]|1[0-2])|30\/(0?[13-9]|1[0-2])|31\/(0?[13578]|1[02]))\/(19|20)?\d{2}$/;
var reDate = reDate4;

function isDate(pStr)
{
  if (reDate.test(pStr.value)) {
    return true;
  } else if (pStr.value != null && pStr.value != "") {
    alert(pStr.value + " não é uma data válida.");
    return false;
    pStr.focus();
  }
} // isDate
	
function doDateCheck(from, to)
{
 if ((from.value != "") || (to.value != ""))
  {
   if (isDate(from) &&  isDate(to))
    {
     if (Date.parse(GetDataUS(from)) <= Date.parse(GetDataUS(to)))
        return true;
     else
      {
       if (from.value == "" || to.value == "")
        {
         alert("Entre com as duas datas.");
         if (from.value=="")
           from.focus();
         else
           to.focus();
        } 
       else 
          {
          alert("Data da " + to.caption + " deve ser posterior a da " + from.caption + ".");
          to.focus();
         }
       return false;
      }
    }
   else
    return false;
  }
 else
  return true;
}

function focusInput(oObj, sValue) {
  if (oObj.value == sValue) { oObj.value = ""; }
}

function blurInput(oObj, sValue) {
  if (oObj.value == "") { oObj.value = sValue; }
}

//-->
</script>
