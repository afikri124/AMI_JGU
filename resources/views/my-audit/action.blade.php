<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">Related Files</button>

<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('my_audit.my_standard', $id) }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Related Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" class="form-control @error('doc_path') is-invalid @enderror" name="doc_path" accept=".png,.jpg,.jpeg,.pdf,.xls,.xlsx">
                    <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" placeholder="Link Drive/Document Audit">
                    <textarea type="text" class="form-control @error('remark_path_auditee') is-invalid @enderror" name="remark_path_auditee" placeholder="MAX 250 characters..."></textarea>
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save and Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>