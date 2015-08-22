<div id="main-content" class="main-content container-fluid">
	<!-- // sidebar -->
	<?php echo $this->
		element('sidebar/productos'); ?>
		<!-- // fin sidebar -->
		<!-- // contenido pricipal -->
		<div id="page-content" class="page-content">
			<section>
				<div class="page-header">
					<h3>
						<i class="aweso-icon-table opaci35">
						</i>
						Producto
						<small>
							<?php echo $producto[ 'Producto'][ 'nombre']; ?>
						</small>
					</h3>
					<p>
						Despliega la lista de todas los Productos
					</p>
				</div>
				<div class="row-fluid">
					<div class="span6 grider">
						<div class="widget widget-simple widget-table">
							<table class="table boo-table table-striped table-condensed table-content bg-blue-light">
								<colgroup>
									<col class="col20" />
									<col class="col20" />
									<col class="col45" />
									<col class="col15" />
								</colgroup>
								<caption>
									Boo Table Caption - Title fot table
									<span>
										Here text in span
									</span>
								</caption>
								<tbody>
									<tr id="DataRow0">
										<td class="bold">
											<a href="#">10248</a>
										</td>
										<td>
											VINET
										</td>
										<td>
											8/16/2012
										</td>
										<td class="text-right">
											32.38
										</td>
									</tr>
									<tr id="DataRow1">
										<td class="bold">
											<a href="#">10249</a>
										</td>
										<td>
											TOMSP
										</td>
										<td>
											8/10/2012
										</td>
										<td class="text-right">
											11.61
										</td>
									</tr>
									<tr id="DataRow2">
										<td class="bold">
											<a href="#">10250</a>
										</td>
										<td>
											HANAR
										</td>
										<td>
											8/12/2012
										</td>
										<td class="text-right">
											65.83
										</td>
									</tr>
								</tbody>
							</table>
							<!-- // BOO TABLE - DTB-2 -->
						</div>
						<!-- // Widget -->
					</div>
					<!-- // Column -->
					<div class="span6 grider">
                    <?php echo $this->Form->create(); ?>
						<li class="control-group">
							<label for="accountAddressState" class="control-label">
								State 2
								<span class="required">
									*
								</span>
							</label>
							<div class="controls">
								<div class="select2-container span6" id="s2id_accountAddressState">
									<a href="#" onclick="return false;" class="select2-choice" tabindex="-1">   <span>Alabama</span><abbr class="select2-search-choice-close" style="display:none;"></abbr>   <div><b></b></div></a>
									<div class="select2-drop select2-with-searchbox select2-offscreen" style="display: block;">
										<div class="select2-search">
											<input type="text" autocomplete="off" class="select2-input" style="" tabindex="-1">
										</div>
										<ul class="select2-results">
										</ul>
									</div>
								</div>
								<select id="accountAddressState" class="span6" name="accountAddressState" style="display: none;">
									<option value="" selected="selected">
										Select a State
									</option>
									<option value="AL">
										Alabama
									</option>
									<option value="AK">
										Alaska
									</option>
									<option value="AZ">
										Arizona
									</option>
									<option value="AR">
										Arkansas
									</option>
									<option value="CA">
										California
									</option>
									<option value="CO">
										Colorado
									</option>
									<option value="CT">
										Connecticut
									</option>
									<option value="DE">
										Delaware
									</option>
									<option value="DC">
										District Of Columbia
									</option>
									<option value="FL">
										Florida
									</option>
									<option value="GA">
										Georgia
									</option>
									<option value="HI">
										Hawaii
									</option>
									<option value="ID">
										Idaho
									</option>
									<option value="IL">
										Illinois
									</option>
									<option value="IN">
										Indiana
									</option>
									<option value="IA">
										Iowa
									</option>
									<option value="KS">
										Kansas
									</option>
									<option value="KY">
										Kentucky
									</option>
									<option value="LA">
										Louisiana
									</option>
									<option value="ME">
										Maine
									</option>
									<option value="MD">
										Maryland
									</option>
									<option value="MA">
										Massachusetts
									</option>
									<option value="MI">
										Michigan
									</option>
									<option value="MN">
										Minnesota
									</option>
									<option value="MS">
										Mississippi
									</option>
									<option value="MO">
										Missouri
									</option>
									<option value="MT">
										Montana
									</option>
									<option value="NE">
										Nebraska
									</option>
									<option value="NV">
										Nevada
									</option>
									<option value="NH">
										New Hampshire
									</option>
									<option value="NJ">
										New Jersey
									</option>
									<option value="NM">
										New Mexico
									</option>
									<option value="NY">
										New York
									</option>
									<option value="NC">
										North Carolina
									</option>
									<option value="ND">
										North Dakota
									</option>
									<option value="OH">
										Ohio
									</option>
									<option value="OK">
										Oklahoma
									</option>
									<option value="OR">
										Oregon
									</option>
									<option value="PA">
										Pennsylvania
									</option>
									<option value="RI">
										Rhode Island
									</option>
									<option value="SC">
										South Carolina
									</option>
									<option value="SD">
										South Dakota
									</option>
									<option value="TN">
										Tennessee
									</option>
									<option value="TX">
										Texas
									</option>
									<option value="UT">
										Utah
									</option>
									<option value="VT">
										Vermont
									</option>
									<option value="VA">
										Virginia
									</option>
									<option value="WA">
										Washington
									</option>
									<option value="WV">
										West Virginia
									</option>
									<option value="WI">
										Wisconsin
									</option>
									<option value="WY">
										Wyoming
									</option>
								</select>
							</div>
						</li>
                        <?php echo $this->Form->end('enviar'); ?>
					</div>
					<!-- // Example row -->
			</section>
			</div>
			<!-- // fin contenido principal -->
		</div>