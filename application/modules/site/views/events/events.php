 <div class="container-fluid">
 	<div class="col-md-12 col-lg-12">
     	<h4 class="page-section-heading">ICPAK scheduled events</h4>
		 	<div class="panel panel-default">
		        <!-- Progress table -->
		        <div class="table-responsive">
		            <table class="table v-middle">
		                <thead>
		                    <tr>
		                        <th width="20">
		                            <div class="checkbox checkbox-single margin-none">
		                                <input id="checkAll" data-toggle="check-all" data-target="#responsive-table-body" type="checkbox" checked>
		                                <label for="checkAll">Check All</label>
		                            </div>
		                        </th>
		                        <th>Date</th>
		                        <th>Event Name</th>
		                        <th>Location</th>
		                        <th>Attendants</th>
		                        <th class="text-right" colspan="4" width="100">Action</th>
		                    </tr>
		                </thead>
		                <tbody id="responsive-table-body">
		                    <tr>
		                        <td>
		                            <div class="checkbox checkbox-single">
		                                <input id="checkbox1" type="checkbox" checked>
		                                <label for="checkbox1">Label</label>
		                            </div>
		                        </td>
		                        <td><span class="label label-default">Tue 17.02 - Wed 18.02.2015</span>
		                        </td>
		                        <td>
		                            Audit Staff Training Workshop: Coast Branch
		                        </td>
		                        </td>
		                        <td>Kisumu beach resort<a href="#"><i class="fa fa-map-marker fa-fw text-muted"></i></a>
		                        </td>
		                        <td>
		                            <div class="progress">
		                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
		                                </div>
		                            </div>
		                        </td>
		                        <td >
		                             <a href="<?php echo base_url();?>events/book-event/1" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="book">Book now</a>
		                           	 <a href="<?php echo base_url();?>events/view-event/1" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="view">View event</a>
		                        </td>
		                    </tr>
		                    <tr>
		                        <td>
		                            <div class="checkbox checkbox-single">
		                                <input id="checkbox2" type="checkbox" checked>
		                                <label for="checkbox2">Label</label>
		                            </div>
		                        </td>
		                        <td><span class="label label-primary">Tue 17.02 - Wed 18.02.2015</span>
		                        </td>
		                        <td>
		                            Audit Staff Training Workshop: Western Branch (Kakamega)
		                        </td>
		                        </td>
		                        <td>Kakamega resort <a href="#"><i class="fa fa-map-marker fa-fw text-muted"></i></a>
		                        </td>
		                        <td>
		                            <div class="progress">
		                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100">
		                                </div>
		                            </div>
		                        </td>
		                          <td >
		                             <a href="<?php echo base_url();?>events/book-event/2" class="btn btn-default btn-xs" data-toggle="tooltip" data-placement="top" title="book">Book now</a>
		                           	 <a href="<?php echo base_url();?>events/view-event/2" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="view">View event</a>
		                        </td>
		                    </tr>
		                </tbody>
		            </table>
		        </div>
		        <!-- // Progress table -->
		        <div class="panel-footer padding-none text-center">
		            <ul class="pagination">
		                <li class="disabled"><a href="#">&laquo;</a>
		                </li>
		                <li class="active"><a href="#">1</a>
		                </li>
		                <li><a href="#">2</a>
		                </li>
		                <li><a href="#">3</a>
		                </li>
		                <li><a href="#">4</a>
		                </li>
		                <li><a href="#">5</a>
		                </li>
		                <li><a href="#">&raquo;</a>
		                </li>
		            </ul>
		        </div>
		    </div>
		</div>
 </div>