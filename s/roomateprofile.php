<?php session_start();
    require_once("includes/DbConfig.php");
	require_once("includes/general.php");
	if(!$_SESSION['user_log_id']) redirect_page("login.php");
	$acq="select * from ".TABLE_USERS." where id=".$_SESSION['user_log_id'];
	$accdetails = $obj_admin_db->fetchNum($acq);
if(isset($_POST['btn_roomate'])) {
$ermsg="";
if(!strlen(trim($_POST['roommate_desc'])) || !strlen(trim($_POST['poster_desc'])) || !strlen(trim($_POST['overnight_guest'])) || !strlen(trim($_POST['occupation'])) || !strlen(trim($_POST['work_shift'])) || !strlen(trim($_POST['cleanliness'])) || !strlen(trim($_POST['time_at_home']))) $ermsg="Select All Fields<br>";
	if($ermsg=="") {
		if($accdetails == 0 ) { 
				$roomat_insert_query="INSERT INTO ".TABLE_ROOMATES." SET 
				roommate_desc='".$_POST['roommate_desc']."',
				poster_desc='".$_POST['poster_desc']."',
				gender='".$_POST['gender']."',
				no_of_residents='".(int)$_POST['no_of_residents']."',
				age_range_from='".(int)$_POST['age_range_from']."',
				age_range_to='".(int)$_POST['age_range_to']."',
				orientation='".$_POST['orientation']."',
				occupation='".$_POST['occupation']."',
				smoking='".$_POST['smoking']."',
				cleanliness='".$_POST['cleanliness']."',
				type='".$_POST['type']."',
				pets='".$_POST['pets']."',
				children='".$_POST['children']."',
				time_at_home='".$_POST['time_at_home']."',
				work_shift='".$_POST['work_shift']."',
				drinks='".$_POST['drinks']."',
				nightout='".$_POST['nightout']."',
				overnight_guest='".$_POST['overnight_guest']."',
				user_id='".$_SESSION['user_log_id']."'"; 
				$roomat_done_query=$obj_admin_db->get_qresult($roomat_insert_query);
				if($roomat_done_query) 
				{
				if($_FILES['profilePic']['name']) move_uploaded_file($_FILES['profilePic']['tmp_name'],"user_images/".$_SESSION['user_log_id'].".jpg");
				echo '<script>location.replace("view_roomateprofile.php");</script>';
				} 
				 else $ermsg="Error submitting data.";
		} else {
				$name_q="select * from ".TABLE_USERS." where id=".$_SESSION['user_log_id'];
				$fulname = $obj_admin_db->fetchRow($name_q);
				$roomat_insert_query="Update ".TABLE_ROOMATES." SET 
				roommate_desc='".$_POST['roommate_desc']."',
				poster_desc='".$_POST['poster_desc']."',
				gender='".$_POST['gender']."',
				no_of_residents='".(int)$_POST['no_of_residents']."',
				age_range_from='".(int)$_POST['age_range_from']."',
				age_range_to='".(int)$_POST['age_range_to']."',
				orientation='".$_POST['orientation']."',
				occupation='".$_POST['occupation']."',
				smoking='".$_POST['smoking']."',
				cleanliness='".$_POST['cleanliness']."',
				pets='".$_POST['pets']."',
				children='".$_POST['children']."',
				time_at_home='".$_POST['time_at_home']."',
				work_shift='".$_POST['work_shift']."',
				drinks='".$_POST['drinks']."',
				type='".$_POST['type']."',
				nightout='".$_POST['nightout']."',
				overnight_guest='".$_POST['overnight_guest']."'
				where user_id='".$_SESSION['user_log_id']."'"; 
				$roomat_done_query=$obj_admin_db->get_qresult($roomat_insert_query);
				if($roomat_done_query) 
				{
				if($_FILES['profilePic']['name']) move_uploaded_file($_FILES['profilePic']['tmp_name'],"user_images/".$_SESSION['user_log_id'].".jpg");
				echo '<script>location.replace("view_roomateprofile.php");</script>';
				} 
		
		
		}	 				
	}
}

if(!isset($_POST['btn_roomate'])) {	
	$acq="select * from ".TABLE_ROOMATES." where user_id=".$_SESSION['user_log_id'];
	$accdetails = $obj_admin_db->fetchRow($acq);
}	$_POST = $accdetails;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pocket Lister | Off-Market Real Estate - Sign Up Now</title>
<link href="css/style2.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.6.2.min.js"></script>
</head>
<body>
</head>
<body>
	<div id="page">
	<?php include("header2.php"); ?>
		<div id="wrap">
			<div class="hd" id="left"></div>
			<div id="main">
				<div class="hd" id="pc"></div>
				<div id="content">
						<div class="hd" id="ic"></div>
		<div class="bx by bc"><div class="b b1">
		 <h2>Edit Your Roomate Profile</h2>
         <table border="0" cellpadding="0" cellspacing="0"class="section">
          <tbody>
		  <tr>
		  		<td align="center" style="color:#FF0000;">&nbsp;<?php if($ermsg) echo $ermsg; ?></td>
		  </tr>
		  
		  
		  <tr>
           <td>
<form method="post" enctype="multipart/form-data">
				
				<style>
					.table_type_1 td{border: 1px solid #D5DBE6;padding:10px 0px;}
					.table_type_1 tr.last td{border:none;}
				</style>
				<table width="100%" cellspacing="6" cellpadding="0" class="table_type_1" bgcolor="#E7EBF2">
					<tbody>
					<tr bgcolor="#FFFFFF">
						<td width="200px" class="medheader">Name:</td>
						<td class="field"><?php echo $_SESSION['user_log_name']; ?></td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Profile picture:</td>
						<td class="field">
							<div class="profile_image">
								<div class="crop">
								<?php
									$my_image_url = "user_images/".$_SESSION['user_log_id'].'.jpg';
									if(!file_exists($my_image_url)) {
										if(isset($_SESSION['user_fb_id'])) $my_image_url = "https://graph.facebook.com/".$_SESSION['user_fb_id'].'/picture?type=large';
										else $my_image_url = "user_images/default.jpg";
									}
								?>
								
								
							<img width="150" height="150" src="<?php echo $my_image_url;?>">
									
								</div>
							</div>
							<br clear="all"/>
							<div align="left" class="marg_top_5"><input type="file" id="profilePic" name="profilePic"></div>
						</td>
					</tr>					
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Criteria</td>
						<td class="field"><input type="radio" <?php if($_POST['type']=='Need') echo 'checked="checked"'; ?> value="Need" name="type" /> &nbsp; Need &nbsp; <input type="radio" <?php if($_POST['type']=='Have') echo 'checked="checked"'; ?> value="Have" name="type" />&nbsp; Have</td>
					</tr>	
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Short description <br>of your ideal roommate:</td>
						<td class="field"><textarea class="large" name="roommate_desc"><?php echo $_POST['roommate_desc']; ?></textarea><div class="smallText">200 or less words</div></td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Short description <br>of yourself:</td>						
						<td class="field"><textarea class="large" name="poster_desc"><?php echo $_POST['poster_desc']; ?></textarea><div class="smallText">200 or less words</div></td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Gender:</td>						
						<td class="field">
							<select  style="width:150px;" name="gender">
								<option <?php if($_POST['gender']=='male') echo 'selected="selected"'; ?> value="male">Male</option>
								<option <?php if($_POST['gender']=='female') echo 'selected="selected"'; ?> value="female">Female</option>								
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Total no of resident(s) <br>in household:</td>						
						<td class="field">
							<select style="width:150px;"  name="no_of_residents">
								<option <?php if($_POST['no_of_residents']=='1') echo 'selected="selected"'; ?> value="1">+1</option>
								<option <?php if($_POST['no_of_residents']=='2') echo 'selected="selected"'; ?> value="2">+2</option>
								<option <?php if($_POST['no_of_residents']=='3') echo 'selected="selected"'; ?> value="3">+3</option>
								<option <?php if($_POST['no_of_residents']=='4') echo 'selected="selected"'; ?> value="4">4 or more</option>
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Age range of resident(s) <br>in household:</td>						
						<td class="field">
							 
							 From <select name="age_range_from">
								<option selected="selected" value="">select new</option>
								<option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> <option value="13">13</option> <option value="14">14</option> <option value="15">15</option> <option value="16">16</option> <option value="17">17</option> <option value="18">18</option> <option value="19">19</option> <option value="20">20</option> <option value="21">21</option> <option value="22">22</option> <option value="23">23</option> <option value="24">24</option> <option value="25">25</option> <option value="26">26</option> <option value="27">27</option> <option value="28">28</option> <option value="29">29</option> <option value="30">30</option> <option value="31">31</option> <option value="32">32</option> <option value="33">33</option> <option value="34">34</option> <option value="35">35</option> <option value="36">36</option> <option value="37">37</option> <option value="38">38</option> <option value="39">39</option> <option value="40">40</option> <option value="41">41</option> <option value="42">42</option> <option value="43">43</option> <option value="44">44</option> <option value="45">45</option> <option value="46">46</option> <option value="47">47</option> <option value="48">48</option> <option value="49">49</option> <option value="50">50</option> <option value="51">51</option> <option value="52">52</option> <option value="53">53</option> <option value="54">54</option> <option value="55">55</option> <option value="56">56</option> <option value="57">57</option> <option value="58">58</option> <option value="59">59</option> <option value="60">60</option> <option value="61">61</option> <option value="62">62</option> <option value="63">63</option> <option value="64">64</option> <option value="65">65</option> <option value="66">66</option> <option value="67">67</option> <option value="68">68</option> <option value="69">69</option> <option value="70">70</option> <option value="71">71</option> <option value="72">72</option> <option value="73">73</option> <option value="74">74</option> <option value="75">75</option> <option value="76">76</option> <option value="77">77</option> <option value="78">78</option> <option value="79">79</option> <option value="80">80</option> <option value="81">81</option> <option value="82">82</option> <option value="83">83</option> <option value="84">84</option> <option value="85">85</option> <option value="86">86</option> <option value="87">87</option> <option value="88">88</option> <option value="89">89</option> <option value="90">90</option> <option value="91">91</option> <option value="92">92</option> <option value="93">93</option> <option value="94">94</option> <option value="95">95</option> <option value="96">96</option> <option value="97">97</option> <option value="98">98</option> <option value="99">99</option> <option value="100">100</option> 
							</select>
							&nbsp; to <select name="age_range_to">
								<option selected="selected" value="">select new</option>
								<option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> <option value="13">13</option> <option value="14">14</option> <option value="15">15</option> <option value="16">16</option> <option value="17">17</option> <option value="18">18</option> <option value="19">19</option> <option value="20">20</option> <option value="21">21</option> <option value="22">22</option> <option value="23">23</option> <option value="24">24</option> <option value="25">25</option> <option value="26">26</option> <option value="27">27</option> <option value="28">28</option> <option value="29">29</option> <option value="30">30</option> <option value="31">31</option> <option value="32">32</option> <option value="33">33</option> <option value="34">34</option> <option value="35">35</option> <option value="36">36</option> <option value="37">37</option> <option value="38">38</option> <option value="39">39</option> <option value="40">40</option> <option value="41">41</option> <option value="42">42</option> <option value="43">43</option> <option value="44">44</option> <option value="45">45</option> <option value="46">46</option> <option value="47">47</option> <option value="48">48</option> <option value="49">49</option> <option value="50">50</option> <option value="51">51</option> <option value="52">52</option> <option value="53">53</option> <option value="54">54</option> <option value="55">55</option> <option value="56">56</option> <option value="57">57</option> <option value="58">58</option> <option value="59">59</option> <option value="60">60</option> <option value="61">61</option> <option value="62">62</option> <option value="63">63</option> <option value="64">64</option> <option value="65">65</option> <option value="66">66</option> <option value="67">67</option> <option value="68">68</option> <option value="69">69</option> <option value="70">70</option> <option value="71">71</option> <option value="72">72</option> <option value="73">73</option> <option value="74">74</option> <option value="75">75</option> <option value="76">76</option> <option value="77">77</option> <option value="78">78</option> <option value="79">79</option> <option value="80">80</option> <option value="81">81</option> <option value="82">82</option> <option value="83">83</option> <option value="84">84</option> <option value="85">85</option> <option value="86">86</option> <option value="87">87</option> <option value="88">88</option> <option value="89">89</option> <option value="90">90</option> <option value="91">91</option> <option value="92">92</option> <option value="93">93</option> <option value="94">94</option> <option value="95">95</option> <option value="96">96</option> <option value="97">97</option> <option value="98">98</option> <option value="99">99</option> <option value="100">100</option> 							
							</select>
							<br>Current age range:<strong></strong>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Gender &amp; orientation <br>of resident(s):</td>						
						<td class="field">
							<select style="width:150px;"  name="orientation">
								<option <?php if($_POST['orientation']=='No Preference') echo 'selected="selected"'; ?> value="No Preference">No Preference</option>
								<option <?php if($_POST['orientation']=='Straight Male') echo 'selected="selected"'; ?> value="Straight Male">Straight Male</option>
								<option <?php if($_POST['orientation']=='Gay Male') echo 'selected="selected"'; ?> value="Gay Male">Gay Male</option>
								<option <?php if($_POST['orientation']=='Straight Female') echo 'selected="selected"'; ?> value="Straight Female">Straight Female</option>
								<option <?php if($_POST['orientation']=='Lesbian') echo 'selected="selected"'; ?> value="Lesbian">Lesbian</option>								
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Occupation of resident(s):</td>						
						<td class="field">
							<select style="width:150px;"  name="occupation">
								<option value="">Select</option>
								<option <?php if($_POST['occupation']=='Professional') echo 'selected="selected"'; ?> value="Professional">Professional</option>
								<option <?php if($_POST['occupation']=='Student') echo 'selected="selected"'; ?> value="Student">Student</option>
								<option <?php if($_POST['occupation']=='Military') echo 'selected="selected"'; ?> value="Military">Military</option>
								<option <?php if($_POST['occupation']=='Unemployed') echo 'selected="selected"'; ?> value="Unemployed">Unemployed</option>								
								<option <?php if($_POST['occupation']=='Retired') echo 'selected="selected"'; ?> value="Retired">Retired</option>								
							</select>
						</td>
					</tr>			
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Work shift:</td>						
						<td class="field">
							<select style="width:150px;"  name="work_shift">
								<option value="">Select</option>
								<option <?php if($_POST['work_shift']=='Day(9-5)') echo 'selected="selected"'; ?>  value="Day(9-5)">Day(9-5)</option>
								<option  <?php if($_POST['work_shift']=='Swing(4-Mid)') echo 'selected="selected"'; ?> value="Swing(4-Mid)">Swing(4-Mid)</option>
								<option <?php if($_POST['work_shift']=='Graveyard(Mid-8)') echo 'selected="selected"'; ?>  value="Graveyard(Mid-8)">Graveyard(Mid-8)</option>																
								<option  <?php if($_POST['work_shift']=='Work From Home') echo 'selected="selected"'; ?> value="Work From Home">Work From Home</option>																
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Smoking:</td>						
						<td class="field">
							<select style="width:150px;"  name="smoking">
								<option <?php if($_POST['smoking']=='Non Smoking') echo 'selected="selected"'; ?>  value="Non Smoking">Non Smoking</option>
								<option <?php if($_POST['smoking']=='Indoor') echo 'selected="selected"'; ?>  value="Indoor">Indoor</option>
								<option <?php if($_POST['smoking']=='Outdoor Only') echo 'selected="selected"'; ?>  value="Outdoor Only">Outdoor Only</option>																
							</select>
						</td>
					</tr>					
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Cleanliness:</td>						
						<td class="field">
							<select style="width:150px;"  name="cleanliness">
								<option value="">Select</option>
								<option <?php if($_POST['cleanliness']=='Very Tidy') echo 'selected="selected"'; ?>  value="Very Tidy">Very Tidy</option>
								<option <?php if($_POST['cleanliness']=='Average') echo 'selected="selected"'; ?>  value="Average">Average</option>
								<option <?php if($_POST['cleanliness']=='Messy') echo 'selected="selected"'; ?>  value="Messy">Messy</option>																
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Pets:</td>						
						<td class="field">
							<select style="width:150px;"  name="pets">
								<option <?php if($_POST['pets']=='No pet') echo 'selected="selected"'; ?>  value="No pet">No pet</option>
								<option <?php if($_POST['pets']=='Dog') echo 'selected="selected"'; ?>  value="Dog">Dog</option>
								<option <?php if($_POST['pets']=='Cat') echo 'selected="selected"'; ?>  value="Cat">Cat</option>																
								<option <?php if($_POST['pets']=='Caged Pet') echo 'selected="selected"'; ?>  value="Caged Pet">Caged Pet</option>																
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Children:</td>						
						<td class="field">
							<select style="width:150px;"  name="children">
								<option <?php if($_POST['children']=='Not Present') echo 'selected="selected"'; ?>  value="Not Present">Not Present</option>
								<option <?php if($_POST['children']=='Present') echo 'selected="selected"'; ?>  value="Present">Present</option>
								<option  <?php if($_POST['children']=='Present On The Weekends') echo 'selected="selected"'; ?> value="Present On The Weekends">Present On The Weekends</option>																								
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Percentage of time <br>at home:</td>						
						<td class="field">
							<select style="width:150px;"  name="time_at_home">
								<option value="">Select</option>
								<option <?php if($_POST['time_at_home']=='100%') echo 'selected="selected"'; ?> value="100%">100%</option>
								<option  <?php if($_POST['time_at_home']=='75%-100%') echo 'selected="selected"'; ?> value="75%-100%">75%-100%</option>
								<option <?php if($_POST['time_at_home']=='50%-75%') echo 'selected="selected"'; ?>  value="50%-75%">50%-75%</option>																
								<option  <?php if($_POST['time_at_home']=='25%-50%') echo 'selected="selected"'; ?> value="25%-50%">25%-50%</option>																
								<option <?php if($_POST['time_at_home']=='Hardly Ever') echo 'selected="selected"'; ?>  value="Hardly Ever">Hardly Ever</option>																
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">How many alcoholic drinks per week:</td>						
						<td class="field">							
							<select style="width:150px;"  name="drinks">
								<option <?php if($_POST['drinks']=='None') echo 'selected="selected"'; ?>  value="None">None</option>
								<option <?php if($_POST['drinks']=='1-3') echo 'selected="selected"'; ?>  value="1-3">1-3</option>
								<option <?php if($_POST['drinks']=='4-6') echo 'selected="selected"'; ?>  value="4-6">4-6</option>																
								<option <?php if($_POST['drinks']=='7-6') echo 'selected="selected"'; ?>  value="7-10">7-10</option>																
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">How many night per week are you out:</td>						
						<td class="field">
							<select style="width:150px;"  name="nightout">
								<option <?php if($_POST['nightout']=='None') echo 'selected="selected"'; ?>  value="None">None</option>
								<option <?php if($_POST['nightout']=='1-3') echo 'selected="selected"'; ?>  value="1-3">1-3</option>
								<option <?php if($_POST['nightout']=='Every Night') echo 'selected="selected"'; ?>  value="Every Night">Every Night</option>																								
							</select>
						</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
						<td class="medheader">Overnight guest(s):</td>						
						<td class="field">
							<select style="width:150px;"  name="overnight_guest">
								<option value="">Select</option>
								<option <?php if($_POST['overnight_guest']=='Yes') echo 'selected="selected"'; ?>  value="Yes">Yes</option>
								<option <?php if($_POST['overnight_guest']=='NO') echo 'selected="selected"'; ?>  value="No">No</option>								
							</select>
						</td>
					</tr>	
					<tr  bgcolor="#FFFFFF" class="last">
						<td class="medheader">&nbsp;</td>						
						<td class="field">
							<br><input type="submit" value="Save" name="btn_roomate">
						</td>
					</tr>					
				</tbody></table>
				</form>
           </td>
          </tr>
         </tbody></table>
        </div></div>
        <div class="bx bz bc"><div class="b b1"><br></div></div>
     				</div>
			</div>
			<div class="hd" id="rel"></div>
			<div class="hd" id="right"></div>
		</div>		<?php include("footer2.php"); ?>
	</div>


</body>
</html>