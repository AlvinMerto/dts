<table>
	<tr>
		<td>
		<td>
			<div style="border: solid 1px #000; max-width: 1200px; float: right; padding-right: 40px; padding-left: 40px;">
				<p style="font-family: Arial, serif; font-size: 9px;">In following up, pls cite Reference #</p>
				<p style="font-family: Arial, serif; font-size: 14px; font-weight: bold;">{{ $data1['barcode'] }}</p>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><img src="{{ $message->embed(public_path() .'/images/minda_logo.png') }}" alt="" height="140px;"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="font-weight: bold;">REPUBLIC OF THE PHILIPPINES</td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="font-weight: bold; font-size: 16px;">MINDANAO DEVELOPMENT AUTHORITY</td>
	</tr>
	<tr>
		<td colspan="2" align="center">Old Airport Bldg., Old Airport Road,</td>
	</tr>
	<tr>
		<td colspan="2" align="center">Km. 9, Sasa, Davao City 8000 Philippines</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="font-weight: bold; font-size: 14px; color: #0140FE;">EMAIL NOTIFICATION</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td colspan="2" align="justify">
			<p>
				Dear Sir/Madam,<br><br>
				&emsp;The <span style="font-weight: bold;">MINDANAO DEVELOPMENT AUTHORITY</span> is sending an email to you for your advance information. This email is about the <span style="font-weight: bold;"> {{ $data1['dsc'] }} </span> with document classification of <span style="font-weight: bold;">{{ $data1['prio'] }}</span> and handed to {{ $data1['corier'] }}.</span><br><br><br>This is a auto-generated mail from MinDA Document Tracking System
			</p>
		</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td>&emsp;Document Title:</td>
		<td>{{ $data1['dsc'] }}</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td>&emsp;Document Reference No:</td>
		<td>{{ $data1['barcode'] }}</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td>&emsp;Date and Time Transmitted:</td>
		<td>{{ Carbon\Carbon::now(+8)->format('l jS \\of F Y @ h:i:s A') }}</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td>&emsp;Uploaded By:</td>
		<td>{{Auth::user()->f_name}}</td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;"></td>
	</tr>
	<tr>
		<td colspan="2" align="left"><img src="{{ $message->embed(public_path() .'/images/dts-image_minda-document_tracking_system.png') }}" alt="" height="100px;"></td>
	</tr>
	<tr>
		<td colspan="2" height="20px;" align="center" style="font-weight: bold;">Auto-generated mail, please do not reply.</td>
	</tr>
</table>
<br>
<br>
<p style="color: #A4A4A4; font-weight: bold; font-family: Georgia, serif;">Old Airport Bldg., Old Airport Road, <br>
Km. 9, Sasa, Davao City 8000 Philippines<br></p>
<p>www.minda.gov.ph<br><br></p>
<p style="color: #A4A4A4;">Telefax No.: (082) 221-7060/(082) 221-6929</p>