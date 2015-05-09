
<table data-toggle="data-table" class="table" cellspacing="0" width="100%">
<thead>
    <th width="20">
       
    </th>
    <th>Created</th>
    <th>File Name</th>
    <th>Attachment</th>
    <!-- <th class="text-right" colspan="2">Actions</th> -->
</thead>
	<tbody id="responsive-table-body">
	     <?php
	        $meeting_attachments = $this->site_model->get_all_meeting_agenda_attachments($meeting_id);
	        if ($meeting_attachments->num_rows() > 0)
	        {
	          
	            $x =0;
	            foreach ($meeting_attachments->result() as $row)
	            {
	                $agenda_attachment_id = $row->agenda_attachment_id;
	                $created = $row->created_on;
	                $attachment_status = $row->attachment_status;
	                $attachment_name = $row->attachment_name;
	                $created_by = $row->created_by;
	                 if($attachment_status == 0)
	                {
	                    $status = '<span class="label label-success btn-xs">Active</span>';
	                    $button = '<a class="btn btn-danger btn-xs "  agenda_attachment_id="'.$agenda_attachment_id.'" onclick="deactivate_attachment('.$agenda_attachment_id.','.$meeting_id.')">Deactivate</a>';
	                }
	                
	                else
	                {
	                    $status = '<span class="label label-danger label-xs">Disabled</span>';
	                    $button = '<a class="btn btn-success btn-xs" onclick="activate_attachment('.$agenda_attachment_id.','.$meeting_id.')">Activate</a>';
	                }
	             
	                $x++;
	                ?>
	                <tr>
	                    <td>
	                        <?php echo $x;?>
	                    </td>
	                     <td>
	                        <span class="label label-default label-xs"><?php echo date('jS M Y H:i a',strtotime($created));?></span>
	                    </td>
	                    <td>
	                        <?php echo $attachment_name;?>
	                    </td>
	                    <td><a href="<?php echo base_url();?>assets/files/<?php echo $attachment_name;?>" target="_blank">Download attachment</a></td>
	                    <!-- <td><?php echo $button;?></td>
	                    <td>
	                        <a  class="btn btn-danger btn-xs " data-toggle="tooltip"  data-placement="top" title="" data-original-title="Delete" onclick="delete_attachment(<?php echo $agenda_attachment_id;?>,<?php echo $meeting_id;?>)"><i class="fa fa-times"></i> Delete from list</a>
	                    </td> -->

	                </tr>
	                <?php    
	            }
	        }
	        ?>
	</tbody>
</table>