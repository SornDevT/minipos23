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
              
      
              </a>
            </div>
            <!-- /Logo -->
            <p class="mb-6">ກະລຸນາປ້ອນຂໍ້ມູນ ເພື່ອລົງທະບຽນ</p>
               <!-- {{username}} -->
            <div id="formAuthentication" class="mb-6 "  novalidate="novalidate">
                <div class="mb-6 ">
                <label for="username" class="form-label">ຊື່:</label>
                <input type="text" class="form-control" id="username" v-model="username" name="email-username" placeholder="Enter your name" >
              </div>
              <div class="mb-6 ">
                <label for="email" class="form-label">ອີເມວລ໌:</label>
                <input type="text" class="form-control" id="email" v-model="email" name="email-username" placeholder="Enter your email" >
              </div>
              <div class="mb-6 form-password-toggle ">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                <div class="input-group input-group-merge has-validation">
                  <input type="password" id="password" class="form-control" v-model="password" name="password" placeholder="············" aria-describedby="password">
                  <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-6 form-password-toggle ">
                <label class="form-label" for="password">ຍືນຍັນລະຫັດຜ່ານ:</label>
                <div class="input-group input-group-merge has-validation">
                  <input type="password" id="password" class="form-control" v-model="password2" name="password" placeholder="············" aria-describedby="password">
                  <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                </div>
              </div>

              <div class="alert alert-warning" v-if="error_message" role="alert">{{error_message}}</div>
             
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" @click="register()" >ລົງທະບຽນ</button>
              </div>
           
            
            </div>

            <p class="text-center">
              <span>ມີບັນຊີແລ້ວ? </span>
              <router-link to="/login" >
                <span>ເຂົ້າສູ່ລະບົບ</span>
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
            username:'',
            email:'',
            password:'',
            password2:'',
            error_message:'',
        }
    },
    methods: {
        // Handle form validation username, email, password, password2, password = password2
        register() {
            if (this.username === '' || this.email === '' || this.password === '' || this.password2 === '') {
                this.error_message = 'ກະລຸນາຂໍ້ມູນໃຫ້ຄົບຖ້ວນ';
                return;
            }
            if (this.password !== this.password2) {
               this.error_message = 'ລະຫັດຜ່ານ ແລະ ຍືນຍັນລະຫັດ ບໍ່ກົງກັນ';
                return;
            } else {
                this.error_message = '';
            }


            // Call API to register
            axios.post('/api/register', {
                username: this.username,
                email: this.email,
                password: this.password,
            })
            .then(response => {
                console.log(response.data);
               
                this.$router.push('/login');
            })
            .catch(error => {
                console.log(error);
                
            });
        }
    },
}
</script>
<style lang="">
    
</style>