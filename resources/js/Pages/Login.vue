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
                <input type="text" class="form-control" id="email" v-model="email" name="email-username" placeholder="Enter your email" >

            </div>
              <div class="mb-6 form-password-toggle form-control-validation fv-plugins-icon-container">
                <label class="form-label"  for="password">ລະຫັດຜ່ານ:</label> 
                <div class="input-group">
                  <input :type="inputPasswordType" v-model="password"  class="form-control" id="password" placeholder="············" >
                  <span @click="inputPasswordType=='password'?inputPasswordType='text':inputPasswordType='password'" class="input-group-text cursor-pointer">
                    <i class="icon-base bx bx-show" v-if="inputPasswordType=='text'"></i>
                    <i class='icon-base bx bx-hide' v-if="inputPasswordType=='password'" ></i>
                    </span>
                </div>

              
              </div>
              <div class="mb-7">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" v-model="remember" id="remember-me">
                    <label class="form-check-label" for="remember-me"> ຈື່ຂ້ອຍໄວ້ໃນລະບົບ </label>
                  </div>
                  
                </div>
              </div>
              <div class="alert alert-warning" role="alert" v-if="error_message_email || error_message_password || error_message_login"> {{error_message_email}} {{ error_message_password }} {{error_message_login}}</div>
              <div class="mb-6"> 
                <!-- {{CheckLoginFrom}} -->
                <button class="btn btn-primary d-grid w-100" @click="Login()" :disabled="CheckLoginFrom" >ເຂົ້າສູ່ລະບົບ</button>
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
export default {
  data() {
    return {
      email: '',
      password: '',
      remember: false,
      error_message_email: '',
      error_message_password: '',
      error_message_login: '',
      inputPasswordType: 'password',
    };
  },
  computed: {
    CheckLoginFrom() {
      
      // check email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (this.email) {
        if(emailRegex.test(this.email)) {
          this.error_message_email = '';
        } else {
          this.error_message_email = 'ອີເມວລ໌ບໍ່ຖືກຕ້ອງ';
        }
      } else {
        this.error_message_email = '';
      }

      // check password
      if (this.password) {
        if(this.password.length >= 6) {
          this.error_message_password = '';
        } else {
          this.error_message_password = 'ລະຫັດຜ່ານຕ້ອງມີ 6 ຕົວຂື້ນໄປ!';
        }
      } else {
        this.error_message_password = '';
      }

      // check all
      if (this.email && this.password && this.error_message_email === '' && this.error_message_password === '') {
        return false;
      } else {
        return true;
      }


    },
  },
  methods:{
    Login(){
      axios.post('/api/login', {
        email: this.email,
        password: this.password,
        remember: this.remember
      }).then(response => {

        console.log(response);

        if(response.data.success){
          // login ສຳເລັດ
          // set token, use to localStorage
          localStorage.setItem('web_token', response.data.token);
          localStorage.setItem('web_user', JSON.stringify(response.data.user));

          // clear form
          this.email = '';
          this.password = '';

          // redirect to dashboard
          this.$router.push('/');

        } else {
          // login ບໍ່ສຳເລັດ
          console.log(response.data.message);
          this.error_message_login = response.data.message;
        }

      }).catch(error => {
        console.log(error);
        this.error_message_login = 'ອີເມວລ໌ ຫຼື ລະຫັດຜ່ານ ບໍ່ຖືກ';
      });
    }
  }
};
</script>
<style lang="">
</style>