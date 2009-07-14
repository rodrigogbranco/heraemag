<?php
require('file.php');
require ("parse.php");

class Metric{
	function barriers(){

		// Alteração VVB - 22/10/2008
		//echo $url_tmp;
		SESSION_START();
		$url_metric = isset ($_SESSION["url_metric"])?$_SESSION["url_metric"]:"";
		$url = $url_metric;
		// ----------------------------------------- end VVB
	
		$user_agent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.10) Gecko/20070302 Ubuntu/dapper-security Firefox/1.5.0.10";
		global $wcag1;

		//require('inc/file.php');
		$File = new File(urldecode($url), $user_agent);

		if ($File->error == '') {
				if (!$File->fetch($File->uri_real, 'base', 'arry')) {
				$opt_head['error'] = "Not fetched";
			} else {
				if ($File->lastredirectaddr != '') {
					$url_redir = $File->uri_real;
				}
				if ($File->meta_redirect != '') {
					$meta_redir = $File->meta_redirect;
				}
			}
		} else {
			$opt_head['error'] = "Not opened";
		}
	
		if ($opt_head['error'] != '') {
			return -1;
		} else { // No error
			//require ("inc/parse.php");
			$parse_res = new Parse;
			$parse_res->This_Page($url_redir, $meta_redir);
	
			if (defined('ID')) { // Parse page was successful
	
	         /*--- Checkpoint 1.1 ---*/
	
				/* Alt text for images 1101*/
	         $this->potential[1101] = $parse_res->tot['img'];
	         if ($parse_res->pto[1101] == "mal") {
		      	$this->barriers[1101] = $parse_res->tot['img'] - $parse_res->tot['alt_img'];                        
	         } else {
					$this->barriers[1101] = 0;
				}
				$this->type['1101'] = 'auto';
				$this->priority['1101'] = 1;
                $this->principle['1101'] = 'p';
		
				/* Alt text for inputs 1102*/
	         $this->potential[1102] = $parse_res->tot['input_image'];
	         if ($parse_res->pto[1102] == "mal") {
		         $this->barriers[1102] = $parse_res->tot['input_image'] - $parse_res->tot['alt_input'];                        
	         } else {
					$this->barriers[1102] = 0;
				}
				$this->type['1102'] = 'auto';
				$this->priority['1102'] = 1;
                $this->principle['1102'] = 'p';
	
				/* Alt text for inputs 1103*/
	         $this->potential[1103] = $parse_res->tot['area'];
	         if ($parse_res->pto[1103] == "mal") {
		         $this->barriers[1103] = $parse_res->tot['area'] - $parse_res->tot['alt_area'];                        
	         } else {
					$this->barriers[1103] = 0;
				}
				$this->type['1103'] = 'auto';
				$this->priority['1103'] = 1;
                $this->principle['1103'] = 'p';

				/* Alt for scripts 1104 - manual*/
	         $this->potential[1104] = $parse_res->tot['script'];
				$this->barriers[1104] = 0;
				$this->priority['1104'] = 1;
				$this->type['1104'] = 'manual';
                $this->principle['1104'] = 'p';
	
				/* Alt text for embed 1105*/
	         $this->potential[1105] = $parse_res->tot['embed'];
	         if ($parse_res->pto[1105] == "mal") {
		         $this->barriers[1105] = $parse_res->tot['embed'] - $parse_res->tot['noembed'];                        
	         } else {
					$this->barriers[1105] = 0;
				}
				$this->type['1105'] = 'manual';
				$this->priority['1105'] = 1;
                $this->principle['1105'] = 'p';

				/* Applets 1106 - manual*/
	         $this->potential[1106] = $parse_res->tot['applet'];
				$this->barriers[1106] = 0;
				$this->priority['1106'] = 1;
				$this->type['1106'] = 'manual';
                $this->principle['1106'] = 'p';

				/* Objets 1107 - manual*/
	         $this->potential[1107] = $parse_res->tot['object'];
				$this->barriers[1107] = 0;
				$this->priority['1107'] = 1;
				$this->type['1107'] = 'manual';
				$this->principle['1107'] = 'p';

				/* Iframes 1108 - manual*/
	         $this->potential[1108] = $parse_res->tot['iframe'];
				$this->barriers[1108] = 0;
				$this->priority['1108'] = 1;
				$this->type['1108'] = 'manual';
				$this->principle['1108'] = 'p';

				/* sounds 1109 - manual*/
	         $this->potential[1109] = $parse_res->tot['hrefson'];
				$this->barriers[1109] = 0;
				$this->priority['1109'] = 1;
				$this->type['1109'] = 'manual';
				$this->principle['1109'] = 'p';

				/* multimedia 1110 - manual*/
	         $this->potential[1110] = $parse_res->tot['hrefapp'];
				$this->barriers[1110] = 0;
				$this->principle[1110] = 'p';
				$this->priority['1110'] = 1;
				$this->type['1110'] = 'manual';
				$this->principle['1110'] = 'p';

				/* Alt content for frames 1111*/
	         if ($parse_res->pto[1111] == "mal") {
		         $this->potential[1111] = $parse_res->tot['frame'];
		         $this->barriers[1111] = 1;                        
	         } else {
		         $this->potential[1111] = $parse_res->tot['frame'] - ($parse_res->tot['noframes'] - $parse_res->tot['noframe_vacio']);
		         $this->barriers[1111] = 0;                        
				}
				$this->type['1111'] = 'auto';
				$this->priority['1111'] = 1;
				$this->principle['1111'] = 'p';
	
				$this->principle[11] = 'p';
				$this->pot_checkpoint['1.1'] = $this->potential[1101] + $this->potential[1102] + $this->potential[1103] + 
					$this->potential[1105] + $this->potential[1111];
				$this->bar_checkpoint['1.1'] = $this->barriers[1101] + $this->barriers[1102] + $this->barriers[1103] + 
					$this->barriers[1105] + $this->barriers[1111];
				
				$this->pot_checkpoint_total['1.1'] = $this->potential[1101] + $this->potential[1102] + $this->potential[1103] + $this->potential[1104] + $this->potential[1105] + $this->potential[1106] + $this->potential[1107] + $this->potential[1108] + $this->potential[1109] + $this->potential[1109] + $this->potential[1111];
				$this->bar_checkpoint_total['1.1'] = $this->barriers[1101] + $this->barriers[1102] + $this->barriers[1103] + $this->barriers[1104] + $this->barriers[1105] + $this->barriers[1106] + $this->barriers[1107] + $this->barriers[1108] + $this->barriers[1109] + $this->barriers[1110] + $this->barriers[1111];
				$this->priority_checkpoint['1.1'] = 1;
				$this->principle_checkpoint['1.1'] = 'p';


				/* Checkpoint 1.2 - ismap - manual*/
	         $this->potential[12] = $parse_res->tot['ismap'];
				$this->barriers[12] = 0;
				$this->principle[12] = 'p';
				$this->priority['12'] = 1;
				$this->type['12'] = 'manual';
				$this->principle['12'] = 'p';

				$this->principle[12] = 'p';
				$this->pot_checkpoint['1.2'] = $this->potential[12];
				$this->bar_checkpoint['1.2'] = 0;
				
				$this->pot_checkpoint_total['1.2'] = $this->potential[12];
				$this->bar_checkpoint_total['1.2'] = 0;
				$this->priority_checkpoint['1.2'] = 1;
				$this->principle_checkpoint['1.2'] = 'p';


				/* Checkpoint 1.3 manual*/

				/* embed 1301 - manual*/
	         $this->potential[1301] = $parse_res->tot['embed'];
				$this->barriers[1301] = 0;
				$this->priority['1301'] = 1;
				$this->type['1301'] = 'manual';
				$this->principle['1301'] = 'p';
				
				/* object 1302 - manual*/
	         $this->potential[1302] = $parse_res->tot['object'];
				$this->barriers[1302] = 0;
				$this->priority['1302'] = 1;
				$this->type['1302'] = 'manual';
				$this->principle['1302'] = 'p';

				/* object 1303 - manual*/
	         $this->potential[1303] = $parse_res->tot['hrefapp'];
				$this->barriers[1303] = 0;
				$this->priority['1303'] = 1;
				$this->type['1303'] = 'manual';
				$this->principle['1303'] = 'p';

				$this->principle[13] = 'p';
				$this->pot_checkpoint['1.3'] = $this->potential[1301] + $this->potential[1302] + $this->potential[1303];
				$this->bar_checkpoint['1.3'] = 0; 
				
				$this->pot_checkpoint_total['1.3'] = $this->potential[1301] + $this->potential[1302] + $this->potential[1303];
				$this->bar_checkpoint_total['1.3'] = 0;
				$this->priority_checkpoint['1.3'] = 1;		    
				$this->principle_checkpoint['1.3'] = 'p';


				/* Checkpoint 1.3 manual*/

				/* embed 1401 - manual*/
	         $this->potential[1401] = $parse_res->tot['embed'];
				$this->barriers[1401] = 0;
				$this->priority['1401'] = 1;
				$this->type['1401'] = 'manual';
				$this->principle['1401'] = 'r';
				
				/* object 1402 - manual*/
	         $this->potential[1402] = $parse_res->tot['object'];
				$this->barriers[1402] = 0;
				$this->priority['1402'] = 1;
				$this->type['1402'] = 'manual';
				$this->principle['1402'] = 'r';

				/* object 1403 - manual*/
	         $this->potential[1403] = $parse_res->tot['hrefapp'];
				$this->barriers[1403] = 0;
				$this->priority['1403'] = 1;
				$this->type['1403'] = 'manual';
				$this->principle['1403'] = 'r';

				$this->pot_checkpoint['1.4'] = $this->potential[1301] + $this->potential[1302] + $this->potential[1303];
				$this->bar_checkpoint['1.4'] = 0; 
				
				$this->pot_checkpoint_total['1.4'] = $this->potential[1301] + $this->potential[1302] + $this->potential[1303];
				$this->bar_checkpoint_total['1.4'] = 0;
				$this->priority_checkpoint['1.4'] = 1;		
				$this->principle_checkpoint['1.4'] = 'r';

	         /*--- Checkpoint 1.5 ---*/
	
				/* Alt links for usemap areas */
	         if ($parse_res->pto[15] == "mal") {
		         $this->potential[15] = $parse_res->tot['area'];
		      	$this->barriers[15] = $parse_res->tot['area_sin_red'];
	         }
				$this->priority['15'] = 3;
				$this->type['15'] = 'auto';
				$this->principle['15'] = 'r';
	
				$this->pot_checkpoint['1.5'] = $this->potential[15];
				$this->bar_checkpoint['1.5'] = $this->barriers[15];

				$this->pot_checkpoint_total['1.5'] = $this->potential[15];
				$this->bar_checkpoint_total['1.5'] = $this->barriers[15];

				$this->priority_checkpoint['1.5'] = 3;
				$this->principle_checkpoint['1.5'] = 'r';
	
				/* Checkpoint 2.1 manual*/

				/* color - manual*/
	         $this->potential[21] = 1;
	      	$this->barriers[21] = 0;
				$this->priority['21'] = 1;
				$this->type['21'] = 'manual';
				$this->principle['21'] = 'p';
	
				$this->pot_checkpoint['2.1'] = 0;
				$this->bar_checkpoint['2.1'] = 0;

				$this->pot_checkpoint_total['2.1'] = $this->potential[21];
				$this->bar_checkpoint_total['2.1'] = $this->barriers[21];

				$this->priority_checkpoint['2.1'] = 1;
				$this->principle_checkpoint['2.1'] = 'p';

				/* Checkpoint 2.2 manual*/

				/* color constrast - manual*/
	         $this->potential[22] = 1;
	      	$this->barriers[22] = 0;
				$this->priority['22'] = 1;
				$this->type['22'] = 'manual';
				$this->principle['22'] = 'p';
	
				$this->pot_checkpoint['2.2'] = 0;
				$this->bar_checkpoint['2.2'] = 0;

				$this->pot_checkpoint_total['2.2'] = $this->potential[22];
				$this->bar_checkpoint_total['2.2'] = $this->barriers[22];

				$this->priority_checkpoint['2.2'] = 2;
				$this->principle_checkpoint['2.2'] = 'p';

				/* image/language - manual*/
	         $this->potential[31] = $parse_res->tot['object'] + $parse_res->tot['applet'] + $parse_res->tot['img'] + $parse_res->tot['embed'];
	      	$this->barriers[31] = 0;
				$this->priority['31'] = 1;
				$this->type['31'] = 'manual';
				$this->principle['31'] = 'r';
	
				$this->pot_checkpoint['3.1'] = $this->potential[31];
				$this->bar_checkpoint['3.1'] = $this->barriers[31];

				$this->pot_checkpoint_total['3.1'] = $this->potential[31];
				$this->bar_checkpoint_total['3.1'] = $this->barriers[31];

				$this->priority_checkpoint['3.1'] = 2;
				$this->principle_checkpoint['3.1'] = 'r';
	


	         /*--- Checkpoint 3.2 ---*/	
	
				/* Existence of DTD */
	         $this->potential[3201] = 1;
	         if ($parse_res->pto[3201] == "mal") {
			     	$this->barriers[3201] = 1;
	         } else {
					$this->barriers[3201] = 0;
				}
				$this->type['3201'] = 'auto';
				$this->priority['3201'] = 2;
				$this->principle['3201'] = 'r';
	
				/* CSS correctness */
	         $this->potential[3202] = 1;
	         if ($parse_res->pto[3202] == "mal") {
			     	$this->barriers[3202] = 1;
	         } else {
					$this->barriers[3202] = 0;
				}
				$this->type['3202'] = 'auto';
				$this->priority['3202'] = 2;
				$this->principle['3202'] = 'r';
			
				$this->pot_checkpoint['3.2'] = $this->potential[3201] + $this->potential[3202];
				$this->bar_checkpoint['3.2'] = $this->barriers[3201] + $this->barriers[3202];

				$this->pot_checkpoint_total['3.2'] = $this->potential[3201] + $this->potential[3202];
				$this->bar_checkpoint_total['3.2'] = $this->barriers[3201] + $this->barriers[3202];

				$this->priority_checkpoint['3.2'] = 2;
				$this->principle_checkpoint['3.2'] = 'r';
	
	         /*--- Checkpoint 3.3 ---*/	
		
				/* Use of tables 3301 */
	         if ($parse_res->pto[3301] == "mal") {
		         $this->potential[3301] = 1;
			     	$this->barriers[3301] = 1;
	         } else {
		         $this->potential[3301] = $parse_res->tot['table'];
					$this->barriers[3301] = 0;
				}
				$this->type['3301'] = 'auto';
				$this->priority['3301'] = 2;
				$this->principle['3301'] = 'r';

				/* HTML elements for presentation 3302 */
	         $this->potential[3302] = $parse_res->tot['b'] + $parse_res->tot['basefont'] + $parse_res->tot['center'] + $parse_res->tot['font'] + $parse_res->tot['i'] + $parse_res->tot['s'] + $parse_res->tot['strike'] + $parse_res->tot['u'];
		     	$this->barriers[3302] = $this->potential[3302];
				$this->type['3302'] = 'auto';
				$this->priority['3302'] = 2;	
				$this->principle['3302'] = 'r';

				/* HTML attributes for presentation 3303 */
	         $this->potential[3303] = $parse_res->tot['attr_pres'];
		     	$this->barriers[3303] = $this->potential[3303];
				$this->type['3303'] = 'auto';
				$this->priority['3303'] = 2;	
				$this->principle['3303'] = 'r';

				$this->pot_checkpoint['3.3'] = $this->potential[3301] + $this->potential[3302] + $this->potential[3303];
				$this->bar_checkpoint['3.3'] = $this->barriers[3301] + $this->barriers[3302] + $this->barriers[3303];

				$this->pot_checkpoint_total['3.3'] = $this->potential[3301] + $this->potential[3302] + $this->potential[3303];
				$this->bar_checkpoint_total['3.3'] = $this->barriers[3301] + $this->barriers[3302] + $this->barriers[3303];

				$this->priority_checkpoint['3.3'] = 2;
				$this->principle_checkpoint['3.3'] = 'r';
	
	         /*--- Checkpoint 3.4 ---*/	
	
				/* Use of absolute values in tables tables */
	         $this->potential[3401] = $parse_res->tot['pot_htmlabs'];
		     	$this->barriers[3401] = $parse_res->tot['htmlabs'];
				$this->type['3401'] = 'auto';
				$this->priority['3401'] = 2;
				$this->principle['3401'] = 'r';
	
				/* Use of absolute values in css */
	         $this->potential[3402] = $parse_res->tot['pot_cssabs'];
		     	$this->barriers[3402] = $parse_res->tot['cssabs'];
				$this->type['3402'] = 'auto';
				$this->priority['3401'] = 2;
				$this->priority['3402'] = 2;
				$this->principle['3402'] = 'r';
	
				$this->pot_checkpoint['3.4'] = $this->potential[3402] + $this->potential[3401];
				$this->bar_checkpoint['3.4'] = $this->barriers[3402] + $this->barriers[3401];

				$this->pot_checkpoint_total['3.4'] = $this->potential[3402] + $this->potential[3401];
				$this->bar_checkpoint_total['3.4'] = $this->barriers[3402] + $this->barriers[3401];

				$this->priority_checkpoint['3.4'] = 2;
				$this->principle_checkpoint['3.4'] = 'r';
	

				/*--- Checkpoint 3.5 h1, h2, etc.---*/	
	
				$total_h = $parse_res->tot['h1'] + $parse_res->tot['h2'] + $parse_res->tot['h3'] + $parse_res->tot['h4'] + $parse_res->tot['h5'] + $parse_res->tot['h6'];
				$this->potential[35] = $total_h;
				$this->barriers[35] = $parse_res->tot['horden'];
				$this->type['35'] = 'auto';
				$priority[35] = 2;
				$this->principle['35'] = 'u';

				$this->pot_checkpoint['3.5'] = $this->potential[35];
				$this->bar_checkpoint['3.5'] = $this->barriers[35];

				$this->pot_checkpoint_total['3.5'] = $this->potential[35];
				$this->bar_checkpoint_total['3.5'] = $this->barriers[35];

				$this->priority_checkpoint['3.5'] = 2;
				$this->principle_checkpoint['3.5'] = 'u';

				/*--- Checkpoint 3.6 ul, ol---*/	
	
				if ($parse_res->pto[36] == 'mal') {
					$this->potential[36] = 1;
					$this->barriers[36] = 1;
				} else {
					$this->potential[36] = $parse_res->tot['li'];
					$this->barriers[36] = 0;
				}
				$this->type['37'] = 'manual';
				$priority[36] = 2;
				$this->principle['36'] = 'u';

				$this->pot_checkpoint['3.6'] = $this->potential[36];
				$this->bar_checkpoint['3.6'] = $this->barriers[36];

				$this->pot_checkpoint_total['3.6'] = $this->potential[36];
				$this->bar_checkpoint_total['3.6'] = $this->barriers[36];

				$this->priority_checkpoint['3.6'] = 2;
				$this->principle_checkpoint['3.6'] = 'u';


				/*--- Checkpoint 3.7 quotation---*/	
	
				$this->potential[37] = 1;
				$this->barriers[37] = 0;
				$this->type['37'] = 'manual';
				$priority[37] = 2;
				$this->principle['37'] = 'u';

				$this->pot_checkpoint['3.7'] = $this->potential[37];
				$this->bar_checkpoint['3.7'] = $this->barriers[37];

				$this->pot_checkpoint_total['3.7'] = $this->potential[37];
				$this->bar_checkpoint_total['3.7'] = $this->barriers[37];

				$this->priority_checkpoint['3.7'] = 2;
				$this->principle_checkpoint['3.7'] = 'u';


				/*--- Checkpoint 4.1 language identification ---*/	
	
				$this->potential[41] = 1;
				$this->barriers[41] = 0;
				$this->type['41'] = 'manual';
				$priority[41] = 1;
				$this->principle['41'] = 'u';

				$this->pot_checkpoint['4.1'] = $this->potential[41];
				$this->bar_checkpoint['4.1'] = $this->barriers[41];

				$this->pot_checkpoint_total['4.1'] = $this->potential[41];
				$this->bar_checkpoint_total['4.1'] = $this->barriers[41];

				$this->priority_checkpoint['4.1'] = 1;
				$this->principle_checkpoint['4.1'] = 'u';


				/*--- Checkpoint 4.2 language alteration ---*/	
	
				$this->potential[42] = 1;
				$this->barriers[42] = 0;
				$this->type['42'] = 'manual';
				$priority[42] = 3;
				$this->principle['42'] = 'u';

				$this->pot_checkpoint['4.2'] = $this->potential[42];
				$this->bar_checkpoint['4.2'] = $this->barriers[42];

				$this->pot_checkpoint_total['4.2'] = $this->potential[42];
				$this->bar_checkpoint_total['4.2'] = $this->barriers[42];

				$this->priority_checkpoint['4.2'] = 3;
				$this->principle['4.2'] = 'u';


	         /*--- Checkpoint 4.3 ---*/	
	
				/* Language identification */
	         if ($parse_res->pto[43] == "mal") {
		         $this->potential[43] = 1;
			     	$this->barriers[43] = 1;
	         } else {
		         $this->potential[43] = 1;
					$this->barriers[43] = 0;
				}	
				$this->type['43'] = 'auto';
				$this->priority['43'] = 3;				
				$this->principle['43'] = 'u';

				$this->pot_checkpoint['4.3'] = $this->potential[43];	
				$this->bar_checkpoint['4.3'] = $this->barriers[43]	;


				$this->pot_checkpoint_total['4.3'] = $this->potential[43] + $this->potential[42] + $this->potential[41];
				$this->bar_checkpoint_total['4.3'] = $this->barriers[43] + $this->barriers[42] + $this->barriers[41];

				$this->priority_checkpoint['4.3'] = 3;
				$this->principle_checkpoint['4.3'] = 'u';


				/* Checkpoint 5.1 - table headers */
	         $this->potential[51] = $parse_res->tot['table'];
		     	$this->barriers[51] = 0;

				$this->type['51'] = 'manual';
				$this->priority['51'] = 1;				
				$this->principle['51'] = 'u';

				$this->pot_checkpoint['5.1'] = 0;	
				$this->bar_checkpoint['5.1'] = 0;


				$this->pot_checkpoint_total['5.1'] = $this->potential[51];
				$this->bar_checkpoint_total['5.1'] = $this->barriers[51];

				$this->priority_checkpoint['5.1'] = 1;
				$this->principle['5.1'] = 'u';

				/* Checkpoint 5.2 - complex tables */
	         $this->potential[52] = $parse_res->tot['table'];
		     	$this->barriers[52] = 0;

				$this->type['52'] = 'manual';
				$this->priority['52'] = 1;				
				$this->principle['52'] = 'u';

				$this->pot_checkpoint['5.2'] = 0;	
				$this->bar_checkpoint['5.2'] = 0;


				$this->pot_checkpoint_total['5.2'] = $this->potential[52];
				$this->bar_checkpoint_total['5.2'] = $this->barriers[52];

				$this->priority_checkpoint['5.2'] = 1;
				$this->principle['5.2'] = 'u';


				/* Checkpoint 5.3 - complex tables */
	         $this->potential[53] = $parse_res->tot['table'];
		     	$this->barriers[53] = 0;

				$this->type['53'] = 'manual';
				$this->priority['53'] = 2;				
				$this->principle['53'] = 'u';

				$this->pot_checkpoint['5.3'] = 0;	
				$this->bar_checkpoint['5.3'] = 0	;

				$this->pot_checkpoint_total['5.3'] = $this->potential[53];
				$this->bar_checkpoint_total['5.3'] = $this->barriers[53];

				$this->priority_checkpoint['5.3'] = 2;
				$this->principle_checkpoint['5.3'] = 'u';


				/* Checkpoint 5.4 - tables for layout */
	         $this->potential[54] = $parse_res->tot['table'];
		     	$this->barriers[54] = 0;

				$this->type['54'] = 'manual';
				$this->priority['54'] = 2;				
				$this->principle['54'] = 'u';

				$this->pot_checkpoint['5.4'] = 0;	
				$this->bar_checkpoint['5.4'] = 0;

				$this->pot_checkpoint_total['5.4'] = $this->potential[54];
				$this->bar_checkpoint_total['5.4'] = $this->barriers[54];

				$this->priority_checkpoint['5.4'] = 2;
				$this->principle_checkpoint['5.4'] = 'u';


   	      /*--- Checkpoint 5.5 ---*/		

				/* Table summaries */	
				if ($parse_res->pto[55] == "mal") {
		         $this->potential[55] = $parse_res->tot['table'];
			     	$this->barriers[55] = $parse_res->tot['table'] - $parse_res->tot['summary'];
  	       	} 	
				$this->type['55'] = 'auto';
				$this->priority['55'] = 3;
				$this->principle['55'] = 'u';

				$this->pot_checkpoint['5.5'] = $this->potential[55];
				$this->bar_checkpoint['5.5'] = $this->barriers[55];

				$this->pot_checkpoint_total['5.5'] = $this->potential[55];
				$this->bar_checkpoint_total['5.5'] = $this->barriers[55];

				$this->priority_checkpoint['5.5'] = 3;
				$this->principle_checkpoint['5.5'] = 'u';

				/* Checkpoint 5.6 - abbreviations in table headers */
	         $this->potential[56] = $parse_res->tot['th'];
		     	$this->barriers[56] = 0;

				$this->type['56'] = 'manual';
				$this->priority['56'] = 3;				
				$this->principle['56'] = 'u';

				$this->pot_checkpoint['5.6'] = 0;	
				$this->bar_checkpoint['5.6'] = 0;

				$this->pot_checkpoint_total['5.6'] = $this->potential[56];
				$this->bar_checkpoint_total['5.6'] = $this->barriers[56];

				$this->priority_checkpoint['5.6'] = 3;
				$this->principle_checkpoint['5.6'] = 'u';

				/* Checkpoint 6.1 - works without stylesheets */
	         $this->potential[61] = $parse_res->tot['style'] + $parse_res->tot['css_externa'] + $parse_res->tot['attr_style'];
		     	$this->barriers[61] = 0;

				$this->type['61'] = 'manual';
				$this->priority['61'] = 1;				
				$this->principle['61'] = 'u';

				$this->pot_checkpoint['6.1'] = 0;	
				$this->bar_checkpoint['6.1'] = 0;

				$this->pot_checkpoint_total['6.1'] = $this->potential[61];
				$this->bar_checkpoint_total['6.1'] = $this->barriers[61];

				$this->priority_checkpoint['6.1'] = 1;
				$this->principle_checkpoint['6.1'] = 'u';

				/*--- Checkpoint 6.2 ---*/	

				/* Applets 6201*/
	         $this->potential[6201] = $parse_res->tot['applet'] + $parse_res->tot['embed'] + $parse_res->tot['object']+ $parse_res->tot['script'];
		     	$this->barriers[6201] = 0;

				$this->type['6201'] = 'manual';
				$this->priority['6201'] = 1;	
				$this->principle['6201'] = 'p';

				/* Images in frames 6202*/
	         if ($parse_res->pto[6202] == "mal") {
		         $this->potential[6202] = $parse_res->tot['frame'];
			     	$this->barriers[6202] = $parse_res->tot['img_en_frame'];
	  	      } 	
				$this->type['6202'] = 'auto';
				$this->priority['6202'] = 1;
				$this->principle['6202'] = 'p';

				$this->pot_checkpoint['6.2'] = $this->potential[6202];
				$this->bar_checkpoint['6.2'] = $this->barriers[6202];

				$this->pot_checkpoint_total['6.2'] = $this->potential[6202] + $this->potential[6201];
				$this->bar_checkpoint_total['6.2'] = $this->barriers[6202] + $this->barriers[6201];
				$this->priority_checkpoint['6.2'] = 1;
				$this->principle_checkpoint['6.2'] = 'p';

				/*--- Checkpoint 6.3 ---*/	

				/* javascript links */
				if ($parse_res->pto[6301] == "mal") {
		         $this->potential[6301] = $parse_res->tot['a'];
			     	$this->barriers[6301] = $parse_res->tot['href_javascript'];
				} 
				$this->priority['6301'] = 1;
				$this->type['6301'] = 'auto';
				$this->principle['6301'] = 'o';

				/* works without scripts 6302*/

	         $this->potential[6302] = $parse_res->tot['script'];
		     	$this->barriers[6302] = 0;

				$this->type['6302'] = 'manual';
				$this->priority['6302'] = 1;	
				$this->principle['6302'] = 'o';

				/* works without embed and object 6303*/

	         $this->potential[6303] = $parse_res->tot['embed'] + $parse_res->tot['object'];
		     	$this->barriers[6303] = 0;

				$this->type['6303'] = 'manual';
				$this->priority['6303'] = 1;	
				$this->principle['6303'] = 'o';

				/* works without applet 6304*/
	         $this->potential[6304] = $parse_res->tot['applet'];
		     	$this->barriers[6304] = 0;

				$this->type['6304'] = 'manual';
				$this->priority['6304'] = 1;	
				$this->principle['6304'] = 'o';

				$this->pot_checkpoint['6.3'] = $this->potential[6301];
				$this->bar_checkpoint['6.3'] = $this->barriers[6301];

				$this->pot_checkpoint_total['6.3'] = $this->potential[6301] + $this->potential[6302] + $this->potential[6303]+ $this->potential[6304];
				$this->bar_checkpoint_total['6.3'] = $this->barriers[6301] + $this->barriers[6302] + $this->barriers[6303] + $this->barriers[6304];

				$this->priority_checkpoint['6.3'] = 1;
				$this->principle_checkpoint['6.3'] = 'o';

				/*--- Checkpoint 6.4 ---*/	

				/* device independence 64 */
	         $this->potential[64] = $parse_res->tot['event_ondblclick'] + $parse_res->tot['event_onmouseover'] + $parse_res->tot['event_onmousemove'] + $parse_res->tot['event_onmouseout'];

		     	$this->barriers[64] = 0 ;
				$this->type['64'] = 'manual';
				$this->priority['64'] = 2;
				$this->principle['64'] = 'o';
	
				$this->pot_checkpoint['6.4'] = 0;
				$this->bar_checkpoint['6.4'] = 0;

				$this->pot_checkpoint_total['6.4'] = $this->potential[64];
				$this->bar_checkpoint_total['6.4'] = $this->barriers[64];
				$this->priority_checkpoint['6.4'] = 2;
				$this->principle['6.4'] = 'o';

				/*--- Checkpoint 6.5 ---*/	

				/* without javascript 6501 */
	         $this->potential[6501] = $parse_res->tot['script'];
		     	$this->barriers[6501] = 0;

				$this->type['6501'] = 'manual';
				$this->priority['6501'] = 2;	
				$this->principle['6501'] = 'r';

				/* frameset without noframe 6502*/
	         if ($parse_res->pto[6502] == "mal") {
		         $this->potential[6502] = $parse_res->tot['frameset'];
			     	$this->barriers[6502] = $parse_res->tot['frameset'] - $parse_res->tot['noframes'];
	         } 
				$this->type['6502'] = 'auto';
				$this->priority['6502'] = 2;
				$this->principle['6502'] = 'r';


				$this->pot_checkpoint['6.5'] = $this->potential[6502];
				$this->bar_checkpoint['6.5'] = $this->barriers[6502];

				$this->pot_checkpoint_total['6.5'] = $this->potential[6502] + $this->potential[6501];
				$this->bar_checkpoint_total['6.5'] = $this->barriers[6502] + $this->barriers[6501];
				$this->priority_checkpoint['6.5'] = 2;
				$this->principle_checkpoint['6.5'] = 'r';
	
				/* Checkpoint 7.1 - no screen intermitence */
	         $this->potential[71] = $parse_res->tot['script'] + $parse_res->elem_prog;
		     	$this->barriers[71] = 0;

				$this->type['71'] = 'manual';
				$this->priority['71'] = 1;				
				$this->principle['71'] = 'o';

				$this->pot_checkpoint['7.1'] = 0;	
				$this->bar_checkpoint['7.1'] = 0;

				$this->pot_checkpoint_total['7.1'] = $this->potential[71];
				$this->bar_checkpoint_total['7.1'] = $this->barriers[71];
				$this->priority_checkpoint['7.1'] = 1;				
				$this->principle_checkpoint['7.1'] = 'o';

				/* Checkpoint 7.2 - no blinking */
	         $this->potential[72] = $parse_res->tot['script'] + $parse_res->tot['blink'] + $parse_res->tot['img'] + $parse_res->elem_prog;
		     	$this->barriers[72] = 0;

				$this->type['72'] = 'manual';
				$this->priority['72'] = 2;				
				$this->principle['72'] = 'o';

				$this->pot_checkpoint['7.2'] = 0;	
				$this->bar_checkpoint['7.2'] = 0;

				$this->pot_checkpoint_total['7.2'] = $this->potential[72];
				$this->bar_checkpoint_total['7.2'] = $this->barriers[72];
				$this->priority_checkpoint['7.2'] = 2;	
				$this->principle_checkpoint['7.2'] = 'o';

				/* Checkpoint 7.3 - no movement */
	         $this->potential[73] = $parse_res->tot['script'] + $parse_res->tot['marquee'] + $parse_res->tot['img'] + $parse_res->elem_prog;
		     	$this->barriers[73] = 0;

				$this->type['73'] = 'manual';
				$this->priority['73'] = 2;				
				$this->principle['73'] = 'o';

				$this->pot_checkpoint['7.3'] = 0;	
				$this->bar_checkpoint['7.3'] = 0;

				$this->pot_checkpoint_total['7.3'] = $this->potential[73];
				$this->bar_checkpoint_total['7.3'] = $this->barriers[73];
				$this->priority_checkpoint['7.3'] = 2;
				$this->principle_checkpoint['7.3'] = 'o';

	         /*--- Checkpoint 7.4 ---*/	
		
				/* Page refresh 7401 - meta*/
	         $this->potential[7401] = $parse_res->tot['meta'];
		     	$this->barriers[7401] = $parse_res->tot['refresh'];

				$this->type['7401'] = 'auto';
				$this->priority['7401'] = 2;
				$this->principle['7401'] = 'o';

				/* Page refresh 7402 - programmable*/
	         $this->potential[7402] = $parse_res->tot['script'] + $parse_res->elem_prog;
		     	$this->barriers[7402] = 1;
	      
				$this->type['7402'] = 'manual';
				$this->priority['7402'] = 2;
				$this->principle['7402'] = 'o';
	
				$this->pot_checkpoint['7.4'] = $this->potential[7401];
				$this->bar_checkpoint['7.4'] = $this->barriers[7401];

				$this->pot_checkpoint_total['7.4'] = $this->potential[7401] + $this->potential[7402];
				$this->bar_checkpoint_total['7.4'] = $this->barriers[7401] + $this->barriers[7402];
				$this->priority_checkpoint['7.4'] = 2;
				$this->principle['7.4'] = 'o';
	
	         /*--- Checkpoint 7.5 ---*/	
		
				/* Page redirect 7501 - meta*/
	         $this->potential[7501] = $parse_res->tot['meta'];
		     	$this->barriers[7501] = $parse_res->tot['redirect'];

				$this->type['7501'] = 'auto';
				$this->priority['7501'] = 2;
				$this->principle['7501'] = 'o';

				/* Page redirect 7502 - programmable*/
	         $this->potential[7502] = $parse_res->tot['script'] + $parse_res->elem_prog;
		     	$this->barriers[7502] = 1;
	      
				$this->type['7502'] = 'manual';
				$this->priority['7502'] = 2;
				$this->principle['7502'] = 'o';

	
				$this->pot_checkpoint['7.5'] = $this->potential[7501];
				$this->bar_checkpoint['7.5'] = $this->barriers[7501];

				$this->pot_checkpoint_total['7.5'] = $this->potential[7501] + $this->potential[7502];
				$this->bar_checkpoint_total['7.5'] = $this->barriers[7501] + $this->barriers[7502];
				$this->priority_checkpoint['7.5'] = 2;
				$this->principle_checkpoint['7.5'] = 'o';
	
	         /*--- Checkpoint 8.1 ---*/	
		
				/* direct accessibility scripts 8101*/
	         $this->potential[8101] = $parse_res->tot['event_ondblclick'] + $parse_res->tot['event_onmouseover'] + $parse_res->tot['event_onmousemove'] + $parse_res->tot['event_onmouseout'] + $parse_res->tot['event_onclick'] + $parse_res->tot['event_onmousedown'] + $parse_res->tot['event_onmouseup'] + $parse_res->tot['event_onkeypress'] + $parse_res->tot['event_onkeydown'] + $parse_res->tot['event_onkeyup'];
		     	$this->barriers[8101] = 0;

				$this->type['8101'] = 'manual';
				$this->priority['8101'] = 2;
				$this->principle['8101'] = 'o';

				/* direct accessibility 8102 - embed*/
	         $this->potential[8102] = $parse_res->tot['embed'];
		     	$this->barriers[8102] = 1;
	      
				$this->type['8102'] = 'manual';
				$this->priority['8102'] = 2;
				$this->principle['8102'] = 'o';

				/* direct accessibility 8103 - applets*/
	         $this->potential[8103] = $parse_res->tot['applet'];
		     	$this->barriers[8103] = 1;
	      
				$this->type['8103'] = 'manual';
				$this->priority['8103'] = 2;
				$this->principle['8103'] = 'o';

				/* direct accessibility 8104 - object*/
	         $this->potential[8104] = $parse_res->tot['object'];
		     	$this->barriers[8104] = 1;
	      
				$this->type['8104'] = 'manual';
				$this->priority['8104'] = 2;
				$this->principle['8104'] = 'o';

	
				$this->pot_checkpoint['8.1'] = 0;
				$this->bar_checkpoint['8.1'] = 0;

				$this->pot_checkpoint_total['8.1'] = $this->potential[8101] + $this->potential[8102] + $this->potential[8103] + $this->potential[8104];
				$this->bar_checkpoint_total['8.1'] = $this->barriers[8101] + $this->barriers[8102] + $this->barriers[8103] + $this->barriers[8104];
				$this->priority_checkpoint['8.1'] = 2;
				$this->principle_checkpoint['8.1'] = 'o';


	         /*--- Checkpoint 9.1 ---*/	
	
				/* servermaped image */
	         if ($parse_res->pto[91] == "mal") {
		         $this->potential[91] = $parse_res->tot['img'];
			     	$this->barriers[91] = $parse_res->tot['ismap'];
	         } 
				$this->type['91'] = 'manual';
				$this->priority['91'] = 1;
				$this->principle['91'] = 'o';
	
				$this->pot_checkpoint['9.1'] = $this->potential[91];
				$this->bar_checkpoint['9.1'] = $this->barriers[91];
				$this->priority_checkpoint['9.1'] = 1;
				$this->principle_checkpoint['9.1'] = 'o';
	

	         /*--- Checkpoint 9.2 ---*/	
		
				/* server image maps 9201*/
	         $this->potential[9201] = $parse_res->tot['img'] + $parse_res->tot['input'];
		     	$this->barriers[9201] = 0;

				$this->type['9201'] = 'manual';
				$this->priority['9201'] = 2;
				$this->principle['9201'] = 'o';

				/* elements with interface - 9202*/
	         $this->potential[9202] = $parse_res->elem_prog;
		     	$this->barriers[9202] = 0;
	      
				$this->type['9202'] = 'manual';
				$this->priority['9202'] = 2;
				$this->principle['9202'] = 'o';

				$this->pot_checkpoint['9.2'] = 0;
				$this->bar_checkpoint['9.2'] = 0;

				$this->pot_checkpoint_total['9.2'] = $this->potential[9201] + $this->potential[9202];
				$this->bar_checkpoint_total['9.2'] = $this->barriers[9201] + $this->barriers[9202];
				$this->priority_checkpoint['9.2'] = 2;
				$this->principle_checkpoint['9.2'] = 'o';

	         /*--- Checkpoint 9.3 ---*/	

	         $this->potential[93] = $parse_res->tot['event_ondblclick'] + $parse_res->tot['event_onmouseover'] + $parse_res->tot['event_onmousemove'] + $parse_res->tot['event_onmouseout'] + $parse_res->tot['event_onclick'] + $parse_res->tot['event_onmousedown'] + $parse_res->tot['event_onmouseup'] + $parse_res->tot['event_onkeypress'] + $parse_res->tot['event_onkeydown'] + $parse_res->tot['event_onkeyup'];
		     	$this->barriers[93] = 0;
				$this->type['93'] = 'manual';
				$this->priority['93'] = 2;
				$this->principle['93'] = 'o';

				$this->pot_checkpoint['9.3'] = 0;
				$this->bar_checkpoint['9.3'] = 0;

				$this->pot_checkpoint_total['9.3'] = $this->potential[93];
				$this->bar_checkpoint_total['9.3'] = $this->barriers[93];
				$this->priority_checkpoint['9.3'] = 2;
				$this->principle_checkpoint['9.3'] = 'o';


	         /*--- Checkpoint 9.4 ---*/	

	         $this->potential[94] = $parse_res->tot['input'] + $parse_res->tot['select'] + $parse_res->tot['textarea'] + $parse_res->tot['a'];
		     	$this->barriers[94] = 0;
				$this->type['94'] = 'manual';
				$this->priority['94'] = 3;
				$this->principle['94'] = 'o';

				$this->pot_checkpoint['9.4'] = 0;
				$this->bar_checkpoint['9.4'] = 0;

				$this->pot_checkpoint_total['9.4'] = $this->potential[94];
				$this->bar_checkpoint_total['9.4'] = $this->barriers[94];
				$this->priority_checkpoint['9.4'] = 3;
				$this->principle_checkpoint['9.4'] = 'o';


	         /*--- Checkpoint 9.5 ---*/	

         	$this->potential[95] = 1;
	         if ($parse_res->pto[95] == "mal") {
		     		$this->barriers[95] = 1;
				}
				$this->type['95'] = 'auto';
				$this->priority['95'] = 3;
				$this->principle['95'] = 'o';

				$this->pot_checkpoint['9.5'] = $this->potential[93];
				$this->bar_checkpoint['9.5'] = $this->barriers[93];

				$this->pot_checkpoint_total['9.5'] = $this->potential[93];
				$this->bar_checkpoint_total['9.5'] = $this->barriers[93];
				$this->priority_checkpoint['9.5'] = 3;
				$this->principle_checkpoint['9.5'] = 'o';

	         /*--- Checkpoint 10.1 ---*/	
		
				/* target 1001*/
	         $this->potential[10101] = $parse_res->tot['attr_target'];
		     	$this->barriers[10101] = 0;

				$this->type['10101'] = 'manual';
				$this->priority['10101'] = 2;
				$this->principle['10101'] = 'o';

				/* scripts - 10102*/
	         $this->potential[10102] = $parse_res->tot['script'] + $this->elem_prog;
		     	$this->barriers[10102] = 0;
	      
				$this->type['10102'] = 'manual';
				$this->priority['10102'] = 2;
				$this->principle['10102'] = 'o';

				$this->pot_checkpoint['10.1'] = 0;
				$this->bar_checkpoint['10.1'] = 0;

				$this->pot_checkpoint['10.1'] = 0;
				$this->bar_checkpoint['10.1'] = 0;

				$this->pot_checkpoint_total['10.1'] = $this->potential[10101] + $this->potential[10102];
				$this->bar_checkpoint_total['10.1'] = $this->barriers[10102] + $this->barriers[10101];
				$this->priority_checkpoint['10.1'] = 2;
				$this->principle_checkpoint['10.1'] = 'o';


	         /*--- Checkpoint 10.2 ---*/	
	
				/* input labels */
	         $this->potential[102] = $parse_res->tot['input_label'] + $parse_res->tot['textarea'] + $parse_res->tot['select'];
		     	$this->barriers[102] = $this->potential[102] - $parse_res->tot['label'];
				$this->type['102'] = 'auto';
				$this->priority['102'] = 2;	
				$this->principle['102'] = 'u';

				$this->pot_checkpoint['10.2'] = $this->potential[102];
				$this->bar_checkpoint['10.2'] = $this->barriers[102];

				$this->pot_checkpoint_total['10.2'] = $this->potential[102];
				$this->bar_checkpoint_total['10.2'] = $this->barriers[102];

				$this->priority_checkpoint['10.2'] = 2;
				$this->principle_checkpoint['10.2'] = 'u';

	         /*--- Checkpoint 10.3 ---*/	
	
				/* linear entries for tables */
	         $this->potential[103] = $parse_res->tot['table'];
		     	$this->barriers[103] = 0;
				$this->type['103'] = 'manual';
				$this->priority['103'] = 3;	
				$this->principle['103'] = 'r';

				$this->pot_checkpoint['10.3'] = 0;
				$this->bar_checkpoint['10.3'] = 0;

				$this->pot_checkpoint_total['10.3'] = $this->potential[103];
				$this->bar_checkpoint_total['10.3'] = $this->barriers[103];

				$this->priority_checkpoint['10.3'] = 3;
				$this->principle_checkpoint['10.3'] = 'r';

		      /*--- Checkpoint 10.4 ---*/	
	
				/* empty inputs */
	         $this->potential[104] = $parse_res->tot['input'] + $parse_res->tot['textarea'];
		     	$this->barriers[104] = $parse_res->tot['input_vacio'];
				$this->priority['104'] = 3;
				$this->type['104'] = 'auto';	
				$this->principle['104'] = 'r';

				$this->pot_checkpoint['10.4'] = $this->potential[104];
				$this->bar_checkpoint['10.4'] = $this->barriers[104];

				$this->pot_checkpoint_total['10.4'] = $this->potential[104];
				$this->bar_checkpoint_total['10.4'] = $this->barriers[104];
				$this->priority_checkpoint['10.4'] = 3;
				$this->principle_checkpoint['10.4'] = 'r';
	
	         /*--- Checkpoint 10.5 ---*/	
	
				/* Adjacent links */
	         $this->potential[105] = $parse_res->tot['a'];
		     	$this->barriers[105] = $parse_res->tot['a_adya'];
				$this->priority['105'] = 3;
				$this->type['105'] = 'auto';		
				$this->principle['105'] = 'r';


				$this->pot_checkpoint['10.5'] = $this->potential[105];
				$this->bar_checkpoint['10.5'] = $this->barriers[105];

				$this->pot_checkpoint_total['10.5'] = $this->potential[105];
				$this->bar_checkpoint_total['10.5'] = $this->barriers[105];

				$this->priority_checkpoint['10.5'] = 3;
				$this->principle['10.5'] = 'r';

	         /*--- Checkpoint 11.1 ---*/	
	
				/* Use of non-standard markup */
	         $this->potential[111] = $parse_res->tot['dtd_vieja'] + $parse_res->tot['applet'] + $parse_res->tot['embed']
						+ $parse_res->tot['blink'] + $parse_res->tot['marquee'] + $parse_res->tot['flash'];
		     	$this->barriers[111] = $this->potential[111];
				$this->priority['111'] = 2;
				$this->type['111'] = 'auto';		
				$this->principle['111'] = 'r';
	
				$this->pot_checkpoint['11.1'] = $this->potential[111];
				$this->bar_checkpoint['11.1'] = $this->barriers[111];

				$this->pot_checkpoint_total['11.1'] = $this->potential[111];
				$this->bar_checkpoint_total['11.1'] = $this->barriers[111];

				$this->priority_checkpoint['11.1'] = 2;
				$this->principle_checkpoint['11.1'] = 'r';
	
	         /*--- Checkpoint 11.2 ---*/	
	
				/* use of deprecated elements */
	         $this->potential[11201] = $parse_res->tot['elem_deprec'];
		     	$this->barriers[11201] = $this->potential[11201];
				$this->priority['11201'] = 2;
				$this->type['11201'] = 'auto';	
				$this->principle['11201'] = 'r';
			
				/* use of deprecated attributes */
	         $this->potential[11202] = $parse_res->tot['attr_deprec'];
		     	$this->barriers[11202] = $this->potential[11202];
				$this->priority['11202'] = 2;
				$this->type['11202'] = 'auto';	
				$this->principle['11202'] = 'r';

				$this->priority['112'] = 2;
	
				$this->pot_checkpoint['11.2'] = $this->potential[11201] + $this->potential[11202];
				$this->bar_checkpoint['11.2'] = $this->barriers[11201] + $this->barriers[11202];

				$this->pot_checkpoint_total['11.2'] = $this->potential[11201] + $this->potential[11202];
				$this->bar_checkpoint_total['11.2'] = $this->barriers[11201] + $this->barriers[11202];

				$this->priority_checkpoint['11.2'] = 2;
				$this->principle_checkpoint['11.2'] = 'r';
		

	         /*--- Checkpoint 11.3 ---*/	
	
				/* preferences */
	         $this->potential[113] = 1;
		     	$this->barriers[113] = 0;
				$this->priority['113'] = 3;
				$this->type['113'] = 'manual';		
				$this->principle['113'] = 'r';

				$this->pot_checkpoint['11.3'] = 0;
				$this->bar_checkpoint['11.3'] = 0;

				$this->pot_checkpoint_total['11.3'] = $this->potential[113];
				$this->bar_checkpoint_total['11.3'] = $this->barriers[113];

				$this->priority_checkpoint['11.3'] = 3;
				$this->principle_checkpoint['11.3'] = 'r';

	         /*--- Checkpoint 11.4 ---*/	
	
				/* alternative page */
	         $this->potential[114] = 1;
		     	$this->barriers[114] = 0;
				$this->priority['114'] = 1;
				$this->type['114'] = 'manual';		
				$this->principle['114'] = 'p';

				$this->pot_checkpoint['11.4'] = 0;
				$this->bar_checkpoint['11.4'] = 0;

				$this->pot_checkpoint_total['11.4'] = $this->potential[113];
				$this->bar_checkpoint_total['11.4'] = $this->barriers[113];

				$this->priority_checkpoint['11.4'] = 1;
				$this->principle_checkpoint['11.4'] = 'p';

	         /*--- Checkpoint 12.1 ---*/	
	
				/* Frame titles */
	         $this->potential[121] = $parse_res->tot['frame'];
		     	$this->barriers[121] = $parse_res->tot['frame'] - $parse_res->tot['titulo_frame'];
				$this->priority['121'] = 1;
				$this->type['121'] = 'auto';		
				$this->principle['121'] = 'o';
	
				$this->pot_checkpoint['12.1'] = $this->potential[121];
				$this->bar_checkpoint['12.1'] = $this->barriers[121];

				$this->pot_checkpoint_total['12.1'] = $this->potential[121];
				$this->bar_checkpoint_total['12.1'] = $this->barriers[121];

				$this->priority_checkpoint['12.1'] = 1;
				$this->principle_checkpoint['12.1'] = 'o';

	         /*--- Checkpoint 12.2 ---*/	
	
				/*  Frames without descriptions */
	         $this->potential[122] = $parse_res->tot['frame'];
		     	$this->barriers[122] = $this->potential[122] - $parse_res->tot['longdesc_frame'];

				$this->type['122'] = 'auto';		
				$this->priority['122'] = 2;
				$this->principle['122'] = 'p';
	
				$this->pot_checkpoint['12.2'] = $this->potential[122];
				$this->bar_checkpoint['12.2'] = $this->barriers[122];

				$this->pot_checkpoint_total['12.2'] = $this->potential[122];
				$this->bar_checkpoint_total['12.2'] = $this->barriers[122];

				$this->priority_checkpoint['12.2'] = 2;
				$this->principle_checkpoint['12.2'] = 'p';

	         /*--- Checkpoint 12.3 ---*/	
	
				/*  Blocks */
	         $this->potential[123] = 1;
	         if ($parse_res->pto[123] == "mal") {
			     	$this->barriers[123] = 1;
				}

				$this->type['123'] = 'auto';		
				$this->priority['123'] = 2;
				$this->principle['123'] = 'u';
	
				$this->pot_checkpoint['12.3'] = $this->potential[123];
				$this->bar_checkpoint['12.3'] = $this->barriers[123];

				$this->pot_checkpoint_total['12.2'] = $this->potential[123];
				$this->bar_checkpoint_total['12.2'] = $this->barriers[123];

				$this->priority_checkpoint['12.3'] = 2;
				$this->principle['12.3'] = 'u';

	
	         /*--- Checkpoint 12.4 ---*/	
	
				/*  Input without label */
	         $this->potential[124] = $parse_res->tot['input_label'] + $parse_res->tot['select'] + $parse_res->tot['textarea'];
		     	$this->barriers[124] = $this->potential[124] - $parse_res->tot['label'] + ($parse_res->tot['label'] - $parse_res->tot	['attr_for']);
				$this->priority['124'] = 2;
				$this->type['124'] = 'auto';		
				$this->principle['124'] = 'o';
	
				$this->pot_checkpoint['12.4'] = $this->potential[124];
				$this->bar_checkpoint['12.4'] = $this->barriers[124];

				$this->pot_checkpoint_total['12.4'] = $this->potential[124];
				$this->bar_checkpoint_total['12.4'] = $this->barriers[124];
				$this->priority_checkpoint['12.4'] = 2;
				$this->principle_checkpoint['12.4'] = 'o';

	         /*--- Checkpoint 13.1 ---*/	
	
				/* link target */
	         $this->potential[131] = $parse_res->tot['a'];
		     	$this->barriers[131] = 0;
				$this->priority['131'] = 2;
				$this->type['131'] = 'manual';		
				$this->principle['131'] = 'u';

				$this->pot_checkpoint['13.1'] = 0;
				$this->bar_checkpoint['13.1'] = 0;

				$this->pot_checkpoint_total['13.1'] = $this->potential[131];
				$this->bar_checkpoint_total['13.1'] = $this->barriers[131];
				$this->priority_checkpoint['13.1'] = 2;
				$this->principle_checkpoint['13.1'] = 'u';


	         /*--- Checkpoint 13.2 ---*/	
	
				/* metadata */
	         $this->potential[132] = 1;
		     	$this->barriers[132] = 0;
				$this->priority['132'] = 2;
				$this->type['132'] = 'manual';		
				$this->principle['132'] = 'u';

				$this->pot_checkpoint['13.2'] = 0;
				$this->bar_checkpoint['13.2'] = 0;

				$this->pot_checkpoint_total['13.2'] = $this->potential[132];
				$this->bar_checkpoint_total['13.2'] = $this->barriers[132];
				$this->priority_checkpoint['13.2'] = 2;
				$this->principle_checkpoint['13.2'] = 'u';

	         /*--- Checkpoint 13.3 ---*/	
	
				/* organization of the site */
	         $this->potential[133] = 1;
		     	$this->barriers[133] = 0;
				$this->priority['133'] = 2;
				$this->type['133'] = 'manual';		
				$this->principle['133'] = 'u';

				$this->pot_checkpoint['13.3'] = 0;
				$this->bar_checkpoint['13.3'] = 0;

				$this->pot_checkpoint_total['13.3'] = $this->potential[133];
				$this->bar_checkpoint_total['13.3'] = $this->barriers[133];
				$this->priority_checkpoint['13.3'] = 2;

	         /*--- Checkpoint 13.4 ---*/	
	
				/* consistent navigation */
	         $this->potential[134] = 1;
		     	$this->barriers[134] = 0;
				$this->priority['134'] = 2;
				$this->type['134'] = 'manual';		
				$this->principle['134'] = 'o';

				$this->pot_checkpoint['13.4'] = 0;
				$this->bar_checkpoint['13.4'] = 0;

				$this->pot_checkpoint_total['13.4'] = $this->potential[131];
				$this->bar_checkpoint_total['13.4'] = $this->barriers[131];
				$this->priority_checkpoint['13.4'] = 2;
				$this->principle_checkpoint['13.4'] = 'o';

	         /*--- Checkpoint 13.5 ---*/	
	
				/* navigation bar */
	         $this->potential[135] = 1;
		     	$this->barriers[135] = 0;
				$this->priority['135'] = 3;
				$this->type['135'] = 'manual';		
				$this->principle['135'] = 'o';

				$this->pot_checkpoint['13.5'] = 0;
				$this->bar_checkpoint['13.5'] = 0;

				$this->pot_checkpoint_total['13.5'] = $this->potential[135];
				$this->bar_checkpoint_total['13.5'] = $this->barriers[135];
				$this->priority_checkpoint['13.5'] = 3;
				$this->principle_checkpoint['13.5'] = 'o';

	         /*--- Checkpoint 13.6 ---*/	
	
				/* group links */
	         $this->potential[136] = 1;
		     	$this->barriers[136] = 0;
				$this->priority['136'] = 3;
				$this->type['136'] = 'manual';		
				$this->principle['136'] = 'u';

				$this->pot_checkpoint['13.6'] = 0;
				$this->bar_checkpoint['13.6'] = 0;

				$this->pot_checkpoint_total['13.6'] = $this->potential[136];
				$this->bar_checkpoint_total['13.6'] = $this->barriers[136];
				$this->priority_checkpoint['13.6'] = 3;
				$this->principle_checkpoint['136'] = 'u';

	         /*--- Checkpoint 13.7 ---*/	
	
				/* search */
	         $this->potential[137] = 1;
		     	$this->barriers[137] = 0;
				$this->priority['137'] = 3;
				$this->type['137'] = 'manual';		
				$this->principle['137'] = 'o';

				$this->pot_checkpoint['13.7'] = 0;
				$this->bar_checkpoint['13.7'] = 0;

				$this->pot_checkpoint_total['13.7'] = $this->potential[137];
				$this->bar_checkpoint_total['13.7'] = $this->barriers[137];
				$this->priority_checkpoint['13.7'] = 3;
				$this->principle_checkpoint['137'] = 'o';

	         /*--- Checkpoint 13.8 ---*/	
	
				/* headers */
	         $this->potential[138] = 1;
		     	$this->barriers[138] = 0;
				$this->priority['138'] = 3;
				$this->type['138'] = 'manual';		
				$this->principle['138'] = 'u';

				$this->pot_checkpoint['13.8'] = 0;
				$this->bar_checkpoint['13.8'] = 0;

				$this->pot_checkpoint_total['13.8'] = $this->potential[138];
				$this->bar_checkpoint_total['13.8'] = $this->barriers[138];
				$this->priority_checkpoint['13.8'] = 3;
				$this->principle_checkpoint['13.8'] = 'u';

	         /*--- Checkpoint 13.9 ---*/	
	
				/* collections */
	         $this->potential[139] = 1;
		     	$this->barriers[139] = 0;
				$this->priority['139'] = 3;
				$this->type['139'] = 'manual';		
				$this->principle['139'] = 'u';

				$this->pot_checkpoint['13.9'] = 0;
				$this->bar_checkpoint['13.9'] = 0;

				$this->pot_checkpoint_total['13.9'] = $this->potential[139];
				$this->bar_checkpoint_total['13.9'] = $this->barriers[139];
				$this->priority_checkpoint['13.9'] = 3;
				$this->principle_checkpoint['13.9'] = 'u';

	         /*--- Checkpoint 13.10 ---*/	
	
				/* ascii */
	         $this->potential[1310] = 1;
		     	$this->barriers[1310] = 0;
				$this->priority['1310'] = 3;
				$this->type['1310'] = 'manual';		
				$this->principle['1310'] = 'p';

				$this->pot_checkpoint['13.10'] = 0;
				$this->bar_checkpoint['13.10'] = 0;

				$this->pot_checkpoint_total['13.10'] = $this->potential[1310];
				$this->bar_checkpoint_total['13.10'] = $this->barriers[1310];
				$this->priority_checkpoint['13.10'] = 3;
				$this->principle_checkpoint['13.10'] = 'p';

	         /*--- Checkpoint 14.1 ---*/	
	
				/* clear language */
	         $this->potential[141] = 1;
		     	$this->barriers[141] = 0;
				$this->priority['141'] = 1;
				$this->type['141'] = 'manual';		
				$this->principle['141'] = 'u';

				$this->pot_checkpoint['14.1'] = 0;
				$this->bar_checkpoint['14.1'] = 0;

				$this->pot_checkpoint_total['14.1'] = $this->potential[141];
				$this->bar_checkpoint_total['14.1'] = $this->barriers[141];
				$this->priority_checkpoint['14.1'] = 1;
				$this->principle_checkpoint['14.1'] = 'u';

	         /*--- Checkpoint 14.2 ---*/	
	
				/* graphics, audio to reinforce the comprehension */
	         $this->potential[142] = 1;
		     	$this->barriers[142] = 0;
				$this->priority['142'] = 3;
				$this->type['142'] = 'manual';		
				$this->principle['142'] = 'p';

				$this->pot_checkpoint['14.2'] = 0;
				$this->bar_checkpoint['14.2'] = 0;

				$this->pot_checkpoint_total['14.2'] = $this->potential[142];
				$this->bar_checkpoint_total['14.2'] = $this->barriers[142];
				$this->priority_checkpoint['14.2'] = 3;
				$this->principle_checkpoint['14.2'] = 'p';

	         /*--- Checkpoint 14.3 ---*/	
	
				/* consistent presentation */
	         $this->potential[143] = 1;
		     	$this->barriers[143] = 0;
				$this->priority['143'] = 3;
				$this->type['143'] = 'manual';		
				$this->principle['143'] = 'u';

				$this->pot_checkpoint['14.3'] = 0;
				$this->bar_checkpoint['14.3'] = 0;

				$this->pot_checkpoint_total['14.3'] = $this->potential[143];
				$this->bar_checkpoint_total['14.3'] = $this->barriers[143];
				$this->priority_checkpoint['14.3'] = 3;
				$this->principle_checkpoint['14.3'] = 'u';


			} else { // Parse page fails
				$opt_head['error'] = "error";
			}
		}

		$this->resume = array($parse_res->pto, $this->pot_checkpoint, $this->bar_checkpoint, $this->barriers, $this->potential, $this->priority);
	}

	function A3_1 ($type) {
		$points_temp = array_keys($this->potential);

		if ($type == 'auto') {

			foreach ($points_temp as $point) {
				if ($this->type[$point] == 'auto')
					$points[] = $point;	
			}
		}
		else {
			$points = $points_temp;
		}

		$total_barriers = 0;
		$total_potential = 0;
		
		$agreg_product = 1;
		foreach ($points as $point) {
			$total_barriers += $this->barriers[$point];
		}
			
		$num_points = 0;
		foreach ($points as $point)
			if ($this->potential[$point] > 0)
				$num_points++;

		$factor = 1 / $num_points;

		if ($total_barriers > 0){ 
			foreach ($points as $point) {
				$Cpb = 0;
				if ($this->potential[$point] > 0) {
					$Cpb = $this->barriers[$point] / $this->potential[$point] + $this->barriers[$point] / $total_barriers;
					$agreg_product = $agreg_product * pow((1 - $factor), $Cpb);
				}
			}
		}
		$agregation = 1 - $agreg_product;
		return ($agregation);
	}

	function A3 ($type) {
		$points_temp = array_keys($this->potential);

		if ($type == 'auto') {

			foreach ($points_temp as $point) {
				if ($this->type[$point] == 'auto')
					$points[] = $point;	
			}
		}
		else {
			$points = $points_temp;
		}

		$total_checks = count($points);

		$weight = 1 / $total_checks;

		$total_barriers = 0;
		
		$agreg_product = 1;
		foreach ($points as $point) {
			$total_barriers += $this->barriers[$point];
		}
			
		if ($total_barriers > 0){ 
			foreach ($points as $point) {
				$Cpb = 0;
				if ($this->potential[$point] > 0) {
					$Cpb = $this->barriers[$point] / $this->potential[$point] + $this->barriers[$point] / $total_barriers;
					$agreg_product = $agreg_product * pow((1 - $weight), $Cpb);
				}
			}
		}
		$agregation = 1 - $agreg_product;
		return ($agregation);
	}


	/* Calculates the agregation function based on potential problems */
	function potential_problems ($type) {
		if ($type == 'auto') {
			$total_barriers = 0;
			$total_potential = 0;

			$points = array_keys($this->pot_checkpoint);
			
			foreach ($points as $point) {
				$total_barriers += $this->bar_checkpoint[$point];
				$total_potential += $this->pot_checkpoint[$point];
			}
		}
		else {
			$total_barriers = 0;
			$total_potential = 0;
			
			$points = array_keys($this->pot_checkpoint_total);

			foreach ($points as $point) {
				$total_barriers += $this->bar_checkpoint_total[$point];
				$total_potential += $this->pot_checkpoint_total[$point];
			}
		}

		if ($total_potential > 0){ 
			$pot = $total_barriers / $total_potential;
		} else {
			$pot = 0;
		}		
		
		return ($pot);
	}

	/* Calculates the original UWEM agregation function */
	function UWEM ($type) {
		
		$points_temp = array_keys($this->potential);

		if ($type == 'auto') {

			foreach ($points_temp as $point) {
				if ($this->type[$point] == 'auto')
					$points[] = $point;	
			}
		}
		else {
			$points = $points_temp;
		}

		$total_checks = count($points);

		$weight = 1 / $total_checks;

		$total_barriers = 0;
		$total_potential = 0;
		
		$agreg_product = 1;
		foreach ($points as $point) {
			$total_barriers += $this->barriers[$point];
		}
			
		if ($total_barriers > 0){ 
			foreach ($points as $point) {
				$Rpb = 0;
				if ($this->potential[$point] != 0) {
					$Rpb = $this->barriers[$point] / $this->potential[$point];
				}
				$agreg_product = $agreg_product * (1 - $Rpb * $weight);
			}
		}
		$agregation = 1 - $agreg_product;
		return ($agregation);
	}

	/* Calculates the original UWEM agregation function */
	function UWEM_1 ($type) {

		$points_temp = array_keys($this->potential);

		if ($type == 'auto') {

			foreach ($points_temp as $point) {
				if ($this->type[$point] == 'auto')
					$points[] = $point;	
			}
		}
		else {
			$points = $points_temp;
		}

		$total_barriers = 0;
		$total_potential = 0;
		
		$agreg_product = 1;
		foreach ($points as $point) {
			$total_barriers += $this->barriers[$point];
		}
			
		$num_points = 0;
		foreach ($this->potential as $pot)
			if ($pot > 0)
				$num_points++;

		$factor = 1 / $num_points;
				
		if ($total_barriers > 0){ 
			foreach ($points as $point) {
				$Rpb = 0;
				if ($this->potential[$point] != 0) {
					$Rpb = $this->barriers[$point] / $this->potential[$point];
				}
				$agreg_product = $agreg_product * (1 - $Rpb * $factor);
			}
		}
		$agregation = 1 - $agreg_product;
		return ($agregation);
	}

	/* Calculates the WAB metric for a single page */
	function WAB ($type) {
		$WAB = 0;
		$violations = 0;

		if ($type == 'auto') {

			$points = array_keys($this->pot_checkpoint);
	
			foreach ($points as $point) {
				if ($this->pot_checkpoint[$point] > 0) {
					$WAB += $this->bar_checkpoint[$point] / $this->pot_checkpoint[$point] * (1/$this->priority_checkpoint[$point]);
					$violations++;
				}
			}
		}
		else {
			$points = array_keys($this->pot_checkpoint_total);
	
			foreach ($points as $point) {
				if ($this->pot_checkpoint_total[$point] > 0) {
					$WAB += $this->bar_checkpoint_total[$point] / $this->pot_checkpoint_total[$point] * (1/$this->priority_checkpoint[$point]);
					$violations++;
				}
			}
		}

			
		return ($WAB);
	}

	/* Calculates the original WAQM */
	function WAQM ($type) {
		$points_temp = array_keys($this->potential);

		if ($type == 'auto') {

			foreach ($points_temp as $point) {
				if ($this->type[$point] == 'auto')
					$points[] = $point;	
			}
		}
		else {
			$points = $points_temp;
		}


		/* Composes the array of principles */
		foreach ($points as $point) {
			$principle = $this->principle[$point];
			$principles[$principle][] = $point;
		}


		$total_barriers = 0;
		$total_potential = 0;

		// Constants for hyperbole tests
		$a = 20;
		$b = 0.30;
		
		// Empirical values for weights for P1, P2 and P3
		$weight['1'] = 0.80;
		$weight['2'] = 0.16;
		$weight['3'] = 0.04;

		$A = 0;
		$n['p'] = 0;
		$n['o'] = 0;
		$n['u'] = 0;
		$n['r'] = 0;
		foreach (array_keys($principles) as $principle) {
			$A_x_sum = 0;	
            $p1 = 0;
            $p1_bar = 0;
            $p1_pot = 0;
            $num_p1 = 0;
            $p2 = 0;
            $p2_bar = 0;
            $p2_pot = 0;
            $num_p2 = 0;
            $p3 = 0;
            $p3_bar = 0;
            $p3_pot = 0;
            $num_p3 = 0;
				foreach ($principles[$principle] as $point) {
                switch ($this->priority[$point]) {
                    case '1': { $p1_bar = $p1_bar + $this->barriers[$point] ;
                                $p1_pot = $p1_pot + $this->potential[$point];
                                $num_p1++;}
                    break;
                    case '2': { $p2_bar = $p2_bar + $this->barriers[$point] ;
                                $p2_pot = $p2_pot + $this->potential[$point];
                                $num_p2++;}
                    break;
                    case '3': { $p3_bar = $p3_bar + $this->barriers[$point] ;
                                $p3_pot = $p3_pot + $this->potential[$point];
                                $num_p3++;}
                    break;
                }
		 			 $n[$principle] = $n[$principle] + 1;
				}
            $A_x = 0;
            for ($i = 1; $i <=3; $i++) {
               $bar = 'p' . $i . '_bar';
               $pot = 'p' . $i . '_pot';
               $value_point = 'p' . $i;
  					if ($$pot > 0){				
    					// $x_line = ($a - 100) / ( ($a / $this->potential[$point]) - (100/$b));
	    				$x_line = ($b * $a - 100 * $b) / ($b * $a - 100);
	    				$ratio = $$bar/$$pot;
    					if ($ratio < $x_line) {
	    					// Calculate S_line				
	    					// $value_point = $this->barriers[$point] * (-100/$b) + 100;
	  	 					$$value_point = -100/$b * $ratio + 100;
	    				}
	    				else {
	    					// Calculate V_line
	    					// $value_point = ( (-$a/$this->potential[$point]) * $this->barriers[$point]) + $a;
	    					$$value_point = -$a * $ratio + $a;
	    				}
	    			}
	    			else {
	    				$$value_point = 100;
	     			}
            }
            $A_x = $p1 * $weight['1'] + $p2 * $weight['2'] + $p3 * $weight['3'];
			$parc[$principle] = $A_x;
			$A = $A + $A_x * count($principles[$principle]);
		}
		$A = $A / (count($principles['p']) + count($principles['o']) + count($principles['u']) + count($principles['r']));

		return ($A);
	}

	/* Calculates the original WAQM */
	function WAQM1 ($type) {
		$points_temp = array_keys($this->potential);

		if ($type == 'auto') {

			foreach ($points_temp as $point) {
				if ($this->type[$point] == 'auto')
					$points[] = $point;	
			}
		}
		else {
			$points = $points_temp;
		}

		$principles['p'] = array('1101', '1102', '1103', '1105', '1111', '15', '3301', '3401', '3402', '6202', '6502');
		$principles['o'] = array('6301', '7401', '7501', '91', '105', '122', '124');
		$principles['u'] = array('43', '55');
		$principles['r'] = array('3201', '3202', '111', '112');
		
		$total_barriers = 0;
		$total_potential = 0;

		// Constants for hyperbole tests
		$a = 20;
		$b = 0.30;
		
		// Empirical values for weights for P1, P2 and P3
		$weight['1'] = 0.80;
		$weight['2'] = 0.16;
		$weight['3'] = 0.04;

		$A = 0;
		$n['p'] = 0;
		$n['o'] = 0;
		$n['u'] = 0;
		$n['r'] = 0;
		foreach (array_keys($principles) as $principle) {
			$A_x_sum = 0;	
			foreach ($principles[$principle] as $point) {
				if ($this->potential[$point] > 0){				
					$x_line = ($a - 100) / ( ($a / $this->potential[$point]) - (100/$b));
					$ratio = $this->barriers[$point]/$this->potential[$point];
					if ($ratio < $x_line) {
						// Calculate S_line				
						$value_point = $this->barriers[$point] * (-100/$b) + 100;
					}
					else {
						// Calculate V_line
						$value_point = (-1 * $a/$this->potential[$point] * $this->barriers[$point]) + $a;
					}
					$weight_point = $weight[$this->priority[$point]];
					$A_x_sum = $A_x_sum + $value_point * $weight_point;
					$n[$principle] = $n[$principle] + 1;
				}
			}
			if ($n[$principle] == 0)
				$A_x = 100;
			else
				$A_x = $A_x_sum / $n[$principle];
			$parc[$principle] = $A_x;
			$A = $A + $A_x * $n[$principle];
		}
		$A = $A / ($n['p'] + $n['o'] + $n['u'] + $n['r']);

		return ($A);
	}

	/* Returns the resume of all results */
	function resume () {
        $resumen['potential'] = $this->potential;
        $resumen['barriers'] = $this->barriers;
        $resumen['pot_checkpoint'] = $this->pot_checkpoint;
        $resumen['bar_checkpoint'] = $this->bar_checkpoint;
		return $resumen;
	}
}

	
?>
