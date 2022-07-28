		<table style="width: 50%; margin: auto;border: 10px solid #ccc;padding: 15px 25px;">
			<tr>
				<td>
					<table style='border-collapse: collapse; font-size: 16px; font-family: calibri;'>
						<tr style='border-bottom:1px solid #ccc;'>
							<td colspan=2 style='text-align: center;'>
								<h2 style='margin-bottom: 0px;'> MinDA Doctracking System </h2>
								<span style="font-size: 14px;font-style: italic;"> Please do not reply to this email </span>
								<div style='margin-bottom: 20px;'> </div>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='padding:15px;'>
								From
							</td>
							<td style='padding:15px;'>
								<?php echo $name; ?>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='padding:15px;'>
								Agency
							</td>
							<td style='padding:15px;'>
								<?php echo $agency; ?>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='padding:15px;'>
								Description
							</td>
							<td style='padding:15px;'>
								<?php echo $desc; ?>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='padding:15px;'>
								Date 
							</td>
							<td style='padding:15px;'>
								<?php echo date("F d, Y", strtotime($date)); ?>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='padding:15px;'>
								Classification
							</td>
							<td style='padding:15px;'>
								<?php echo $class; ?>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='padding:15px;'>
								Actions
							</td>
							<td style='padding:15px;'>
								<div>
									<?php echo $actions; ?>
								</div>
							</td>
						</tr>
						<tr style='border-bottom:1px solid #ccc;'>
							<td style='width:200px; padding:15px;'>
								Other Instruction
							</td>
							<td style='padding:15px;'>
								<?php echo $othins; ?>
							</td>
						</tr>
						<tr>
							<td> &nbsp; </td>
							<td style='padding:15px;'>
								<p style="background: #79dfea;float: left;padding: 10px;">
									<a href="#" style="text-decoration: none;color: #fff;font-size: 16px;"> View document </a>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>