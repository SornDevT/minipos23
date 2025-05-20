<template lang="">
    <div class=" d-flex justify-content-center ">
        <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Login -->
        <div class="card px-sm-6 px-0">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="index.html" class="app-brand-link gap-2">
              
                <span class="app-brand-text demo text-heading fw-bold">ສະບາຍດີ</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">ຍິນດີຕ້ອງຮັບ 👋</h4>
            <p class="mb-6">ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

            <div id="formAuthentication" class="mb-6 fv-plugins-bootstrap5 fv-plugins-framework"  novalidate="novalidate">
              <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label for="email" class="form-label">ອີເມວລ໌:</label>
                <input type="text" class="form-control" id="email" name="email-username" placeholder="Enter your email" >
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
              <div class="mb-6 form-password-toggle form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                <div class="input-group input-group-merge has-validation">
                  <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                  <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                </div><div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>
              <div class="mb-7">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember-me">
                    <label class="form-check-label" for="remember-me"> ຈື່ຂ້ອຍໄວ້ໃນລະບົບ </label>
                  </div>
                  
                </div>
              </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit">ເຂົ້າສູ່ລະບົບ</button>
              </div>
           
            
            </div>

            <p class="text-center">
              <span>ທ່ານເປັນຜູ້ໃຊ້ໃໝ່ແມ່ນບໍ່? </span>
              <router-link to="/register" >
                <span>ລົງທະບຽນ</span>
              </router-link>
            </p>

            
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
    
    </div>
</template>
<script>
export default {};
</script>
<style lang="">
</style>