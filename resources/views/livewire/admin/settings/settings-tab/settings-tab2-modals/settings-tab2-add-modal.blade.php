<div wire:ignore.self class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModal" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
           <h1 class="modal-title fs-5 fw-bold" id="addDocumentModal">Add Document</h1>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit="addCompanyDocuments">
          <div class="modal-body">
            @csrf
            <div class="row gap-3">
              <div class="col-12">
                  <label for="name" class="form-label fw-bold">Document Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" placeholder="Document Name"
                    wire:model.live.debounce.500ms="name">
                  @error('name') 
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-12">
                  <label for="document" class="form-label fw-bold">Document</label>
                  <input type="file" class="form-control @error('document') is-invalid @enderror"
                    id="document" placeholder="File"
                    wire:model.live.debounce.500ms="document"
                    accept=".pdf,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                  @error('document') 
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-outline-success shadow-sm">Add</button>
              <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
     </div>
  </div>
</div>