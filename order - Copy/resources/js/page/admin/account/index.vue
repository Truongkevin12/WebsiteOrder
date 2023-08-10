<template>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">Thông tin đăng nhập</h5>
          <!-- Account -->
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <!-- <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar"/> -->
              <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Upload hình ảnh</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg"/>
                </label>
                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                  <i class="bx bx-reset d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Reset</span>
                </button>
                <p class="text-muted mb-0">Hình ảnh không quá 2MB</p>
              </div>
            </div>
          </div>
          <hr class="my-0" />
          <div class="card-body">
            @if (Auth::check() )
            <form id="formAccountSettings" method="POST" onsubmit="return false">
              <div class="row">
                <div class="mb-12 col-md-12">
                  <label for="firstName" class="form-label">Tên nhân viên</label>
                  <input class="form-control" type="text" id="firstName" name="firstName" value="{{ Auth::user()->display_name }}" autofocus
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="lastName" class="form-label">Mã nhân viên</label>
                  <input class="form-control" type="text" name="lastName" id="lastName" value="{{ Auth::user()->username }}" readonly />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input class="form-control" type="text" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="john.doe@example.com"
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="phoneNumber">Số điện thoại</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">VN (+84)</span>
                    <input type="text" id="phoneNumber" name="phoneNumber" value="{{ Auth::user()->phone }}" class="form-control" placeholder="202 555 0111"
                    />
                  </div>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="address" class="form-label">Mã khách hàng</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Mã khách hàng" />
                </div>
              </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
              </div>
            </form>
            @endif
          </div>
          <!-- /Account -->
        </div>
      </div>
    </div>
  </template>
