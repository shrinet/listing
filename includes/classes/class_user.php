<?php		
	//user details
	class user {		
		//data from user table
		function set_user_data($id) {
			global $obj_admin_db;
			$user_select_query="SELECT * FROM ".TABLE_USERS." WHERE user_id=$id";
			$user_select_row=$obj_admin_db->fetchRow($user_select_query);
			if(!$user_select_row) {
				redirect_url('index.php');
			}  
			return $user_select_row;
		}
		
		//data from page
		function set_data($udata) {
			return $udata;
		}
		
		//validations 
		function check_data($data, $id=0) {						
			global $obj_db, $captcha;
			$er = array();
			if(!strlen(trim($data["user_fname"]))) $er['fname']="Enter first name";
			if(!strlen(trim($data["user_lname"]))) $er['lname']="Enter last name";
			if($id==0) {
				if(!strlen(trim($data["user_name"])) || $data["user_name"]=="username") $er['user']="Enter Username";			
				if(!strlen(trim($data['user_pword'])) || $data["user_pword"]=="PASSWORD") $er['pword']="Enter Password";			
				if(!strlen(trim($data['user_cpword']))) $er['cpword']="Enter Confirm Password";						
				if(!strlen(trim($data['user_email']))) $er['email']="Enter Email";
				if(!strlen(trim($data['user_cemail']))) $er['email']="Enter Confirm Email";
			}			
			
			/*else {
				$email_sel_query="SELECT * FROM ".TABLE_USERS." WHERE user_email='".mysql_escape_string(strtolower(trim($data['user_email'])))."' ";
				$email_sel_row = $obj_db->fetchRow($email_sel_query);
				if($email_sel_row) $er['email']=array("class"=>" show","msg"=>"Email appeares to be incorrect");
			}*/
			if(!strlen(trim($data["user_city"]))) $er['city']="Enter city";
			if(!strlen(trim($data["user_state"]))) $er['state']="Enter state";
			if($id==0) if(!strlen(trim($data["user_check"]))) $er['agree']="Please check the agree box";
			
			//echo "<pre>";print_r($er);echo "</pre>";		
			
			if(count($er)) {
				$er=array();
				$er['error']="* marked fields are manedatory";
			} else {
					$er=array();
					if($data['user_name']) {
						if(
						ctype_alnum($data['user_name']) // numbers & digits only
						&& strlen($data['user_name'])>5 // at least 7 chars
						&& strlen($data['user_name'])<21 // at most 20 chars
						&& (preg_match('`[A-Z]`',$data['user_name']) // at least one upper case
						|| preg_match('`[a-z]`',$data['user_name']) // at least one lower case
						|| preg_match('`[0-9]`',$data['user_name']) // at least one digit
						)){
							if(is_numeric(substr(trim($data["user_name"]),0,1))) $er['user']="Username first letter should not be number";
							else {
								$user_sel_query="SELECT user_name FROM ".TABLE_USERS." WHERE user_name='".mysql_real_escape_string(strtolower(trim($data['user_name'])))."' AND user_id<>$id";
								$user_sel_row = $obj_db->fetchRow($user_sel_query);
								if($user_sel_row) $er['user']="Username already exists";
							}
						}else{
							$er['user']="Username Between 6-21 characters and use a-z,0-9 only";
						}
					}	
					if($data['user_cpword']) {
						if(
						ctype_alnum($data['user_pword']) // numbers & digits only
						&& strlen($data['user_pword'])>5 // at least 7 chars
						&& strlen($data['user_pword'])<21 // at most 20 chars
						&& (preg_match('`[A-Z]`',$data['user_pword']) // at least one upper case
						|| preg_match('`[a-z]`',$data['user_pword']) // at least one lower case
						|| preg_match('`[0-9]`',$data['user_pword']) // at least one digit
						)){
							$e = "";// valid
						}else{
							$er['pword']="Password Between 6-21 characters and use a-z,A-Z,0-9 only";
						}
					}	
				
					if($id==0) {						
					
						if($data['user_pword']<>$data['user_cpword']) $er['cpword']="Passwords do not match";
					
						if (!eregi("^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $data['user_email']))	$er['email']="Invalid Email";
						
						if($data['user_email']<>$data['user_cemail']) $er['cemail']="Email addresses do not match";
					} else {
						if($data['user_cpword'])
							if($data['user_pword']<>$data['user_cpword']) $er['cpword']="Passwords do not match";
						if($data['user_cemail'])
							if($data['user_email']<>$data['user_cemail']) $er['cemail']="Email addresses do not match";
							
						if($_FILES['user_photo']['name']) 
						{
							$vext=strtolower(substr(strrchr($_FILES['user_photo']['name'],"."),1));
							if(!($vext=="jpg" || $vext=="gif" || $vext=="png"))
								$ermsg .="* Photo should have the type JPG or GIF or PNG.<br>";
						}				
					}	
							
			}
			/*if(!isset($_SESSION['user'])) {
				if (empty($_SESSION['captcha']) || trim(strtolower($data['user_captcha'])) != $_SESSION['captcha'])
					$er['captcha']=array("class"=>" show","msg"=>"Invalid Captcha");						
				if(!strlen(trim($data['user_agree']))) 
					$er['agree']=array("class"=>" show","msg"=>"Check Terms and conditions");	
			}*/	
			//echo "<pre>";print_r($er);echo "</pre>";		
			
			return $er;
		}

		
		//data INSERTING
		function register_user($data) {
			global $obj_db;
			
			$query_user="INSERT INTO ".TABLE_USERS." SET 
									user_title='".mysql_real_escape_string($data["user_title"])."', 
									user_name='".mysql_real_escape_string(strtolower(trim($data["user_name"])))."', 
									user_password='".mysql_real_escape_string(md5(trim($data["user_pword"])))."', 
									user_pword='".mysql_real_escape_string($data["user_pword"])."', 
									user_fname='".mysql_real_escape_string($data["user_fname"])."', 
									user_lname='".mysql_real_escape_string($data["user_lname"])."' , 
									user_email='".mysql_real_escape_string($data["user_email"])."' , 
									user_country='".mysql_real_escape_string($data["user_country"])."' , 
									user_state='".mysql_real_escape_string($data["user_state"])."' , 
									user_city='".mysql_real_escape_string($data["user_city"])."' , 
									user_tel='".mysql_real_escape_string($data["user_tel"])."' , 
									user_school='".mysql_real_escape_string($data["user_school"])."' , 
									user_brand='".mysql_real_escape_string($data["user_brand"])."' , 
									user_instruments='".mysql_real_escape_string($data["user_instruments"])."' , 
									user_genre='".mysql_real_escape_string($data["user_genre"])."' , 
									user_bio='".mysql_real_escape_string($data["user_bio"])."' , 
									user_heard='".mysql_real_escape_string($data["user_heard"])."' , 
									user_status='1'  ";
			
			$user_insert_result=$obj_db->get_qresult($query_user);
			if($user_insert_result) {
				$user_id  = mysql_insert_id();
				$rand_key = random_alpha(6).$user_id.random_alpha(3);
				//SIGNUP CONFIRMATION MAIL
			$mail_body = '<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial; font-size:13px; align="left">				
						<tr>
							<td>
								<img src="'.curPageURL().'/images/logo.jpg" />
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="2">
								Dear '.$data["user_fname"].' '.$data["user_lname"].', 
							</td>
						</tr>
						<tr>
							<td align="left" colspan="2">Welcome! Thank you for joining The 30-30 Career. Your registration was completed successfully.</td>
						</tr>
						<tr>
							<td align="left" colspan="2"><b>Login Details</b>
						</tr>
						<tr>
							<td align="left" width="100px">Username: </td>
							<td>'.strtolower(trim($data["user_name"])).'
						</tr>
						<tr>
							<td align="left">Password: </td>
							<td>'.htmlentities(trim($data["user_pword"])).'</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="2">Enjoy the site! <br />Your friends at The 30-30 Career</td>
						</tr>
					</table>';
					
				
				$From_Display = SITE_NAME;
				$From_Email = ADMIN_EMAIL;
				$To_Email =strtolower(trim($data['user_email']));
				$CC = "";
				$BCC = "";
				$Sub = "Account Confirmation";
				$Message = $mail_body;
				$Format = 1;
				$mail_responce = SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);
				$_SESSION['user'] = array("id"=>$user_id, "name"=>strtolower(trim($data["user_name"])));
				//echo '<br>'.$To_Email.'<br>'.$msg.'<br>';
				//return array("error"=>"success");
				redirect_url("account.php");
			} else return array("error"=>"Your registration not completed due to some technical problem, so please try to submit again.");
		}
		
		
		//user data update
		function update_user_profile($data,$id) {
			global $obj_db;
			$sub_qeury="";
			if($_FILES['upload_resume']['name']) $sub_qeury=" , user_resume='".mysql_real_escape_string($_FILES['upload_resume']['name'])."'";
			
			$query_user="UPDATE ".TABLE_USERS." SET 
									user_name='".mysql_real_escape_string($data["user_name"])."',
									user_fullname='".mysql_real_escape_string($data["user_fullname"])."',  
									birthday='".mysql_real_escape_string($data["birthday"])."', 
									user_gender='".mysql_real_escape_string($data["user_gender"])."' , 									
									user_occcupation='".mysql_real_escape_string($data["user_occcupation"])."' , 
									user_city='".mysql_real_escape_string($data["user_city"])."' , 
									user_state='".mysql_real_escape_string($data["user_state"])."' , 
									user_country='".mysql_real_escape_string($data["user_country"])."' , 
									user_ethnicity='".mysql_real_escape_string($data["user_ethnicity"])."' , 
									user_genre='".mysql_real_escape_string($data["user_genre"])."' , 
									user_website='".mysql_real_escape_string($data["user_website"])."' , 
									user_blog='".mysql_real_escape_string($data["user_blog"])."' , 
									user_favartists='".mysql_real_escape_string($data["user_favartists"])."',
									user_hobbies='".mysql_real_escape_string($data["user_hobbies"])."' ,  
									user_bio='".mysql_real_escape_string($data["user_bio"])."' ".$sub_qeury."
									where user_id='$id'  ";
			
			//mysql_query($query_user)or die(mysql_error());
			
			
			$user_insert_result=$obj_db->get_qresult($query_user);
			
			if($_FILES['user_photo']['name']) {
					$ext=substr(strrchr($_FILES['user_photo']['name'],"."),1);
					$ext=strtolower($ext);				
					$img_propery=USER_IMAGES.$id.".jpg";
					if(move_uploaded_file($_FILES['user_photo']['tmp_name'], $img_propery)) {
						//$thumb=make_thumb($img_propery,$img_propery,100,100,$ext);
					}
				
			
			}
			if($_FILES['upload_resume']['name']) {
									
					$resume=USER_IMAGES."resume/".$_FILES['upload_resume']['name'];
					move_uploaded_file($_FILES['upload_resume']['tmp_name'], $resume);
			}
			
			
			if($user_insert_result) {
				redirect_page("my_dashboard.php");
			} else return "Your account not updated due to some technical problem, so please try to submit again.";
		}
		
		//user login
		function user_login($data) {
			global $obj_db;
			$ermsg = "";
			if(!strlen(trim($data['user_name'])) || $data['user_name']=="username") $ermsg="* Enter username<br/>";
			if(!strlen(trim($data['user_pword'])) || $data['user_pword']=="PASSWORD") $ermsg .="* Enter password";
			if($ermsg) $ermsg = "Enter login info";
			if($ermsg == "") {
				$user_sel_query="SELECT user_id, user_name FROM ".TABLE_USERS." WHERE user_name='".mysql_real_escape_string(strtolower(trim($data["user_name"])))."' and user_password='".mysql_real_escape_string(md5(trim($data['user_pword'])))."' ";
				$user_sel_row = $obj_db->fetchRow($user_sel_query);
				if($user_sel_row) {
					$_SESSION['user'] = array("id"=>$user_sel_row['user_id'], "name"=>$user_sel_row['user_name']);
					if($data['chk_rememberme']){
					  $_SESSION[chk_remb]="cookie";	
					}
				} else $ermsg="Invalid login";
			}
			return $ermsg;
		}
		
		//user forgot password
		function user_forgot($data) {
			global $obj_db;
			$er=array();
			if(!strlen(trim($data['user_email']))) 
				$er['email']=array("class"=>" show","msg"=>"Enter email address");
			else if (!eregi("^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$", $data['user_email']))
				$er['email']=array("class"=>" show","msg"=>"Invalid email address");
			else {
				$email_sel_query="SELECT user_email FROM ".TABLE_USERS." WHERE user_email='".mysql_real_escape_string(strtolower(trim($data['user_email'])))."' ";
				$email_sel_row = $obj_db->fetchRow($email_sel_query);
				if(!$email_sel_row) $er['email']=array("class"=>" show","msg"=>"Email appeares not found");
			}
			if(!isset($_SESSION['user'])) {
				if (empty($_SESSION['captcha']) || trim(strtolower($data['user_captcha'])) != $_SESSION['captcha'])
					$er['captcha']=array("class"=>" show","msg"=>"Invalid Captcha");						
			}			
			if(!count($er)) {
				$user_sel_query="SELECT * FROM ".TABLE_USERS." WHERE user_email='".mysql_real_escape_string(strtolower(trim($data['user_email'])))."' and user_status=1 ";
				$user_sel_row = $obj_db->fetchRow($user_sel_query);
				if($user_sel_row) {
					$user_sel_row = remove_slashes($user_sel_row);
					//FORGOT PASSWORD MAIL
					$mail_body = '<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial; font-size:13px; align="left">				
							<tr>
								<td>
									<img src="images/logo.jpg" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="left">
									Dear '.$user_sel_row['user_fname'].', 
								</td>
							</tr>
							<tr>
								<td align="left">
									Your username: '.$user_sel_row['user_name'].', 
								</td>
							</tr>
							<tr>
								<td align="left">
									Password: '.trim($user_sel_row['user_pword']).'
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="left">Enjoy the site! <br />Your friends at MomLifeTV</td>
							</tr>
						</table>';
						
					
					$From_Display = SITE_NAME;
					$From_Email = ADMIN_EMAIL;
					$To_Email =$user_sel_row['user_email'];
					$CC = "";
					$BCC = "";
					$Sub = "Forgot Password Request";
					$Message = $mail_body;
					$Format = 1;
					$mail_responce = SendMail($From_Display,$From_Email,$To_Email,$CC,$BCC,$Sub,$Message,$Format);
					if($mail_responce) {
						return array("error"=>"Your password sent to your email address, please check your mail box.");
					} else return array("error"=>"Your password sending to your email address failed, so please try again.");
				} $er['email']=array("class"=>" show","msg"=>"Email appeares not found");
			}
			return $er;
		}
		
		//user retrieve password
		function user_retrieve_password($data) {
			global $obj_db;
			$ermsg = "";
			if(!strlen(trim($data['vk_user_password']))) $ermsg .="* Enter password";	
			if($ermsg == "") {
				$user_sel_query="SELECT user_id, user_email, user_display_name  FROM ".TABLE_USERS." WHERE user_email='".mysql_escape_string(strtolower(trim($data['vk_user_email'])))."' and user_password='".mysql_escape_string(md5(trim($data['vk_user_password'])))."' and user_status=1 ";
				$user_sel_row = $obj_db->fetchRow($user_sel_query);
				if($user_sel_row) {
					//$_SESSION['user'] = array("id"=>$user_sel_row['user_id'], "email"=>$user_sel_row['user_email'], "name"=>$user_sel_row['user_display_name']);
					//redirect_url(BASE_URL."");
				} else $ermsg="* Invalid login details";
			}
			return $ermsg;
		}
		
		
		
		
		
		
		
		////////////////Ask Question
		//user retrieve password
		function user_ask_question($data,$id) {
			global $obj_db;
			$ermsg = "";
			
			
			if(!strlen(trim($data['ques']))) $ermsg ="* Enter Question";	
			
			if($ermsg == "") {
				 $user_qus="INSERT INTO ".TABLE_USER_QUESTION." SET 
									ques='".mysql_real_escape_string($data["ques"])."', 
									user_id=".$id.",
									status= 1
									";
		
				$user_qus_result=$obj_db->get_qresult($user_qus);
				if($user_qus_result) {
					//$_SESSION['user'] = array("id"=>$user_sel_row['user_id'], "email"=>$user_sel_row['user_email'], "name"=>$user_sel_row['user_display_name']);
					//redirect_url(BASE_URL."");
				} else $ermsg="* Not Submitted";
			}
			return $ermsg;
		}
		
		
		
		
		////////////Comments
		function user_comment($data,$id) {
			global $obj_db;
			$ermsg = "";
			
			
			
			
			if(!strlen(trim($data['comment']))) $ermsg ="* Enter Comment";	
			
			if($ermsg == "") {
				 $user_qus="INSERT INTO ".TABLE_USER_COMMENTS." SET 
									ques_id=".mysql_real_escape_string($data["ques_id"]).", 
									comment='".mysql_real_escape_string($data["comment"])."', 
									user_id=".$id."									
									";
		
				$user_qus_result=$obj_db->get_qresult($user_qus);
				if($user_qus_result) {
					redirect_page("profile.php?id=".$data['author']);
					
				} else $ermsg="* Not Submitted";
			}
			return $ermsg;
		}
		
		
		
		
		
		
		
		//user login
		function user_poll($data) {
			global $obj_db;
			$ermsg = "";
			if(!(int)$data['p']) return;
			$poll_sel_query="SELECT * FROM ".TABLE_POLLING." WHERE quest_id='".(int)$data['p']."' ";
			$poll_sel_row = $obj_db->fetchRow($poll_sel_query);
			if(!$poll_sel_row) return;			
			if(!(int)$data['qanswer']) $ermsg ="Select Answer";
			if($ermsg == "") {
				$poll_insert_query="INSERT INTO ".TABLE_POLL_LIST." SET poll_id='".(int)$data['p']."', poll_answer='".(int)$data['qanswer']."', poll_ip='".mysql_escape_string($_SERVER['REMOTE_ADDR'])."'";
				$obj_db->get_qresult($poll_insert_query);
				redirect_url("index.php?poll");
			}
			return $ermsg;
		}
		
		function user_video_comment($data,$id) {
			global $obj_db;
			$ermsg = "";
			
			if((int)$_SESSION['user']['id']==0)	{
				redirect_page("login.php");
			}		 
			
			if(!strlen(trim($data['comment']))) $ermsg ="* Enter Comment";
			
			if($ermsg == "") {
				 $user_qus="INSERT INTO ".TABLE_VIDEO_COMMENTS." SET comment_vid='".$id."', comment_comment='".mysql_real_escape_string($data["comment"])."', comment_user='".$_SESSION['user']['id']."'";		
				 $user_qus_result=$obj_db->get_qresult($user_qus);
				if($user_qus_result) {
					redirect_page("video.php?v=".$id);
				} else $ermsg="* Not Submitted";
			}
			return $ermsg;
		}
		function check_track_data($data, $id) {						
			global $obj_db, $captcha;
			$er = "";
			if(!strlen(trim($data["track_title"]))) $er .="Enter track title.<br/>";
			if(!strlen(trim($data["track_description"]))) $er.="Enter track description.<br/>";
			if($id) if(!strlen(trim($_FILES['track_mp3']['name']))) $er.="Browse an mp3 file.<br/>";
			elseif($_FILES['track_mp3']['name']) 
						{
							$vext=strtolower(substr(strrchr($_FILES['track_mp3']['name'],"."),1));
							if(!($vext=="mp3"))
								$er .="* File should be of type audio.<br>";
						}
			return $er;
		}
		function user_add_track($data, $id,$track_id) {						
			global $obj_db, $captcha;
			$er = "";
			
			if($track_id) $obj_db->get_qresult("update ".TABLE_TRACKS." set user_track_title='".mysql_real_escape_string($data['track_title'])."',user_track_desc='".mysql_real_escape_string($data['track_description'])."' where track_id=".(int)$track_id);
			else $obj_db->get_qresult("insert into ".TABLE_TRACKS." set user_track_title='".mysql_real_escape_string($data['track_title'])."',user_track_desc='".mysql_real_escape_string($data['track_description'])."',user_id=".(int)$id);
			if(!$track_id) $track_id=mysql_insert_id();
			$path_1=USER_MP3.$track_id.".mp3";
			if(move_uploaded_file($_FILES['track_mp3']['tmp_name'],$path_1)) {
				$xml_output = '<?xml version="1.0" encoding="UTF-8"?>'; 
				$xml_output .= '<songs>';
				$xml_output .= '<song url="audiofiles/'.$track_id.'" artist="'.htmlentities($data['track_title']).'" track="'.htmlentities($data['track_title']).'" />';
				$xml_output .= '</songs>';
				$fh = fopen('audio/xml/'.$track_id.'.xml', 'w');
				fwrite($fh, $xml_output);
			 }
			 redirect_page("my_music.php");
			return $er;
		}
		function delte_user_track($id) {						
			global $obj_db, $captcha;
			$er = "";
			$path_1=USER_MP3.$id.".mp3";
			$er=$obj_db->get_qresult("delete from  ".TABLE_TRACKS." where track_id=".(int)$id);
			if($er)	{
				unlink($path_1);
				unlink("audio/xml/".$id.".xml");
			}
			redirect_page("my_music.php");
		}
		function check_video_data($data) {						
			global $obj_db, $captcha;
			$er = "";
			if(!strlen(trim($data["vname"]))) $er .="Enter video title.<br/>";
			if(!strlen(trim($data["description"]))) $er.="Enter video description.<br/>";
			if(!strlen(trim($data["tags"]))) $er.="Enter video tags.<br/>";
			if(!strlen(trim($_FILES['v_image']['name']))) $er.="Browse a video image of type jpg,png.<br/>";
			/*elseif($_FILES['v_image']['name']) 
				{
					$vext1=strtolower(substr(strrchr($_FILES['v_image']['name'],"."),1));
					if(!($vext1=="jpg") || !($vext1=="png"))
						$er .="* video image must be of type jpg,png.<br>";
				}*///echo $_FILES['v_video']['type'];
			if(!strlen(trim($_FILES['v_video']['name']))) $er.="Browse a video file.<br/>";
			
			elseif($_FILES['v_video']['type']<>'video/mp4' && $_FILES['v_video']['type']<>'video/x-ms-wmv' && $_FILES['v_video']['type']<>'video/x-flv')  
				{
						$er .="* Video file should be FLV or MP4 or WEBM or WMV.<br>";
				}
			return $er;
		}
		function user_add_video($data, $id) {						
			global $obj_db, $captcha;
			$er = "";
			
			$obj_db->get_qresult("insert into ".TABLE_VIDEOS." set vname='".mysql_real_escape_string($data['vname'])."',description='".mysql_real_escape_string($data['description'])."',user_id=".(int)$id.",video_file_name='".mysql_real_escape_string($_FILES['v_video']['name'])."',tags='".mysql_real_escape_string($data['tags'])."'");
			$video_id=mysql_insert_id();
			$path_v=VIDEO_FILES.$_FILES['v_video']['name'];
			$path_i=VIDEO_FILES."/images/".$video_id.".jpg";
			if(move_uploaded_file($_FILES['v_video']['tmp_name'],$path_v) && move_uploaded_file($_FILES['v_image']['tmp_name'],$path_i)) {
				redirect_page("my_dashboard.php");
			 }
			return $er;
		}
		function delte_user_video($id) {						
			global $obj_db, $captcha;
			$er = "";
			$video_file_name=$obj_db->fetchRow("select video_file_name from ".TABLE_VIDEOS." where videoid=".(int)$id);
			$path_v=VIDEO_FILES.$video_file_name['video_file_name'];
			$path_i=VIDEO_FILES."/images/".$id.".jpg";
			$er=$obj_db->get_qresult("delete from  ".TABLE_VIDEOS." where videoid=".(int)$id);
			if($er)	{
				unlink($path_v);
				unlink($path_i);
			}
			redirect_page("my_dashboard.php");
		}
	}
?>