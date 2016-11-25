<!-- Modal (Pop up when detail button clicked) -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Message Editor</h4>
            </div>
            <div class="modal-body">
                <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">

                    <div class="form-group error">
                        <div class="row">
                            <label for="inputTask" class="col-sm-3 control-label">Message</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control has-error" id="mess" name="message" placeholder="Message" value="">
                            </div>
                        </div>
                        <div class="row">
                            <label for="inputTask" class="col-sm-3 control-label">Teams</label>
                            <div class="col-sm-9">

                                <select multiple class="form-control" id="team-edit" name="teams[]">

                                    @foreach($data['teams'] as $team)
                                        <option value={{$team->id}}>{{$team->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Save message</button>
                <input type="hidden" id="message_id" name="message_id" value="0">
            </div>
        </div>
    </div>
</div>
