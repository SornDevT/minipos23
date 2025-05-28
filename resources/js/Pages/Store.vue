<template lang="">
    <div class="card">
    <h5 class="card-header">ລາຍການສິນຄ້າທັງໝົດ</h5>
    <div class="card-body">
        <!-- {{ SelectCategory }} -->

        <div class="row" v-if="ShowForm"> 
          <!-- {{FormProduct}} -->
              <div class="col-md-4 relative">
                    <button type="button" class="btn rounded-pill btn-icon btn-danger bimg" v-if="FormProduct.image" @click="ClearImage()">
                            <i class='bx bx-x-circle fs-4'></i>
                    </button>

                <img :src="imagePreview" @click="$refs.imageupload.click()"  class="img-fluid mb-4 cursor-pointer" >

                <input type="file" ref="imageupload" class="form-control mb-4" style=" display:none" id="product_image" accept="image/*" @change="onFileChange">    

              </div>
              <div class="col-md-8">

                  <div class="row">
                      <div class="col-md-6"> 
                        <div class="mb-4">
                          <label for="product_name" class="form-label">ຊື່ສິນຄ້າ: <span class="text-danger">*</span> </label>
                          <input type="text" v-model="FormProduct.name" class="form-control" id="product_name" placeholder="......">
                        </div>
                      </div>
                      <div class="col-md-6">
                        
                      </div>


                      <div class="col-md-6">
                         <div class="mb-4">
                          <label for="product_qty" class="form-label">ຈຳນວນ: <span class="text-danger">*</span></label>
                          <cleave  v-model="FormProduct.qty" :options="options" class="form-control" id="product_qty" placeholder="......" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-4">
                            <label for="product_category" class="form-label">ໝວດໝູ່ສິນຄ້າ <span class="text-danger">*</span></label>
                            <select class="form-select" v-model="FormProduct.category_id" id="product_category" >
                              <option :value="item.id" v-for="item in CategoryData" :key="item.id"> {{ item.name }} </option>
                            </select>
                          </div>
                        </div>

                      <div class="col-md-6">
                         <div class="mb-4">
                          <label for="product_price" class="form-label">ລາຄາຊື້: <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <cleave :options="options" v-model="FormProduct.price_buy" class="form-control" id="product_price" placeholder="...." />
                            <span class="input-group-text" id="basic-addon11">ກີບ</span>
                          </div>
                        </div>
                        </div>
                      <div class="col-md-6">
                            <div class="mb-4">
                          <label for="product_price" class="form-label">ລາຄາຂາຍ: <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <cleave :options="options" v-model="FormProduct.price_sell" class="form-control" id="product_price" placeholder="...." />
                            <span class="input-group-text" id="basic-addon11">ກີບ</span>
                          </div>
                        </div>
                        </div>

                  </div>

              </div>
              <div class="col-12 text-center">
                  <button type="button" :disabled="IsFormValid" @click="SaveProduct()" class="btn btn-primary me-2">ບັນທຶກ</button>
                  <button type="button" class="btn btn-danger" @click="CancelProduct()">ຍົກເລີກ</button>
              </div>
        </div>

  
     


      <div v-else>
        <div class="row"> 
            <div class="col-lg-6 d-flex mb-2 align-items-center">

                <span class="me-2 cursor-pointer" @click="Sort = Sort === 'asc' ? 'desc' : 'asc'">
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                </span>

                <select class="form-select w-auto me-2" v-model="PerPage" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>

                <select class="form-select w-auto" v-model="SelectCategory" >
                <option value="all">ທັງໝົດ</option>
                <option :value="item.id" v-for="item in CategoryData" :key="item.id"> {{ item.name }} </option>
                </select>

            </div>
            <div class="col-lg-6 mb-2 d-flex justify-content-end">

                <div class="input-group w-auto me-2">
                    <input type="text" class="form-control" v-model="Search" placeholder="ຄົ້ນຫາ...." @keyup.enter="GetProduct()" >
                    <button class="btn btn-primary px-3" type="button" @click="GetProduct()" ><i class='bx bx-search-alt'></i></button>
                </div>
                <button type="button" class="btn btn-info" @click="AddProduct()" >ເພີ່ມໃໝ່</button>
            </div>

        </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>ຮູບພາບ</th>
              <th>ຊື່ສິນຄ້າ</th>
              <th>ໝວດໝູ່</th>
              <th>ຈຳນວນ</th>
              <th>ລາຄາຊື້</th>
              <th>ຈັດການ</th>
            </tr>
          </thead>
          <tbody v-if="ProductData.data.length > 0">
            <tr v-for="item in ProductData.data" :key="item.id">
              <td>{{ item.id }}</td>
              <td>
                <div class=" d-flex justify-content-center align-items-center">
                    <img v-if="item.image" :src="url + '/assets/img/products/' + item.image" class="img-fluid rounded border" style="width: 50px; height: 50px;" />
                    
                    <img v-else :src="url + '/assets/img/no-image.jpg'" class="img-fluid rounded border" style="width: 50px; height: 50px;" />
                    </div>
              </td>
              <td>{{ item.name }}</td>
              <td>{{ item.category_name }}</td>
              <td class="text-center">{{ formatPrice(item.qty) }}</td>
              <td class="text-end">{{ formatPrice(item.price_buy) }} ກີບ</td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                  <div class="dropdown-menu" style="">
                    <a class="dropdown-item" @click="EditProduct(item.id)" href="javascript:void(0);"><i class="icon-base bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                    <a class="dropdown-item" @click="DeleteProduct(item.id)" href="javascript:void(0);"><i class="icon-base bx bx-trash me-1"></i> ລຶບ</a>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7" class="text-center"> <i class='bx bxs-data'></i> ບໍ່ມີຂໍໍ່ມູນ</td>
                </tr>
            </tbody>
        </table>
        <Pagination :pagination="ProductData" :offset="4" @paginate="GetProduct($event)" />
      </div>
    </div>

    </div>
  </div>
</template>
<script>
import { useStore } from "../Store/Auth";
export default {
    setup() {
        const store = useStore();
        return { store }
    },
    data(){
        return {
            url: window.location.origin,
            imagePreview: window.location.origin + '/assets/img/img-upload.jpg',
            Search: '',
            Sort:'asc',
            PerPage: 5,
            ShowForm: false,
            FormType: true,
            EditID:'',
            CategoryData: [],
            ProductData:[{
              data: [],
            }],
            SelectCategory: 'all',
            FormProduct: {
                name: '',
                category_id: '',
                image:'',
                qty: '',
                price_buy: '',
                price_sell: '',
            },
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: '.',
                  delimiter: ','
                }
        }
    },
    computed: {
        // check form
        IsFormValid() {
            if(this.FormProduct.name === '' || this.FormProduct.category_id === '' || this.FormProduct.qty === '' || this.FormProduct.price_buy === '' || this.FormProduct.price_sell === '') {
                return true; // form is not valid
            } else {
                return false; // form is valid
            }
        }
    },
    methods:{
        ClearImage(){
            // clear image
            this.FormProduct.image = '';
            this.imagePreview = window.location.origin + '/assets/img/img-upload.jpg';
            this.$refs.imageupload.value = ''; // reset file input
        },
        onFileChange(e){
            console.log(e);
            const file = e.target.files[0];
            this.FormProduct.image = file;
            if(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.imagePreview = window.location.origin + '/assets/img/img-upload.jpg';
            }
        },
      formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
      AddProduct(){
            // show form
            this.ShowForm = true;
            this.FormType = true;
            this.EditID = '';

            // clear form
            this.FormProduct = {
                name: '',
                category_id: '',
                image: '',
                qty: '',
                price_buy: '',
                price_sell: '',
            };

            this.imagePreview = window.location.origin + '/assets/img/img-upload.jpg';

            // select first category
            if(this.CategoryData.length > 0) {
                this.FormProduct.category_id = this.CategoryData[0].id;
            }

        },
      CancelProduct(){
            // hide form
            this.ShowForm = false;
        },
        EditProduct(id){
            // show form
            
            this.FormType = false;
            this.EditID = id;

            // get product by id
            axios.get('/api/product/edit/' + id, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                if(response.data.success) {
                    this.ShowForm = true;
                    this.FormProduct = response.data.product;
                    // check if image is available
                    if(this.FormProduct.image) {
                        this.imagePreview = this.url + '/assets/img/products/' + this.FormProduct.image;
                    } else {
                        this.imagePreview = this.url + '/assets/img/no-image.jpg';
                    }

                } else {
                    // show error message
                    this.$swal({
                        title: "ຜິດຜາດ!",
                        text: response.data.message,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3500,
                    });
                }
            }).catch(error => {
                console.log(error);
                if(error && error.response && error.response.status === 401) {
                    
                    this.$swal({
                        title: "Token ໝົດອາຍຸ!",
                        text: "ກະລຸນາ Login ໃໝ່ອີກຄັ້ງ!",
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3500,
                    }).then(() => {
                        console.log('Redirecting to login page...');
                        // clear token
                        this.store.logOut();
                        // clear local storage
                        localStorage.removeItem('web_token');
                        localStorage.removeItem('web_user');
                        // redirect to login page
                        this.$router.push('/login');
                    });
                }
            });
        },
        SaveProduct(){
            // save product
            if(this.FormType) {
                // add product
                axios.post('/api/product/add', this.FormProduct, { headers:{ "Content-Type":"multipart/form-data" , Authorization: 'Bearer ' + this.store.getToken } }).then(response => {

                    if(response.data.success){
                        this.$swal({
                            title: response.data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true,
                            position: 'top-end',
                        });
                        this.GetProduct(); // refresh product list
                    } else {
                        // show error message
                        this.$swal({
                            title: "ຜິດຜາດ!",
                            text: response.data.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    }

                    // hide form
                    this.ShowForm = false;

                }).catch(error => {
                    if(error && error.response && error.response.status === 401) {
                    
                    this.$swal({
                        title: "Token ໝົດອາຍຸ!",
                        text: "ກະລຸນາ Login ໃໝ່ອີກຄັ້ງ!",
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3500,
                    }).then(() => {
                        console.log('Redirecting to login page...');
                        // clear token
                        this.store.logOut();
                        // clear local storage
                        localStorage.removeItem('web_token');
                        localStorage.removeItem('web_user');
                        // redirect to login page
                        this.$router.push('/login');
                    });
                }
                });


            } else {
                // update product
                axios.post('/api/product/update/' + this.EditID, this.FormProduct, {  headers:{ "Content-Type":"multipart/form-data" , Authorization: 'Bearer ' + this.store.getToken } }).then(response => {

                    if(response.data.success){
                        this.$swal({
                            title: response.data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true,
                            position: 'top-end',
                        });
                        this.GetProduct(); // refresh product list
                    } else {
                        // show error message
                        this.$swal({
                            title: "ຜິດຜາດ!",
                            text: response.data.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    }

                    // hide form
                    this.ShowForm = false;

                }).catch(error => {
                    if(error && error.response && error.response.status === 401) {
                    
                    this.$swal({
                        title: "Token ໝົດອາຍຸ!",
                        text: "ກະລຸນາ Login ໃໝ່ອີກຄັ້ງ!",
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3500,
                    }).then(() => {
                        console.log('Redirecting to login page...');
                        // clear token
                        this.store.logOut();
                        // clear local storage
                        localStorage.removeItem('web_token');
                        localStorage.removeItem('web_user');
                        // redirect to login page
                        this.$router.push('/login');
                    });
                }
                });
            }

        },
        DeleteProduct(id){
            // delete product
            this.$swal({
               title: "ທ່ານແນ່ໃຈບໍ່?",
                text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "ຍຶນຍັນ!",
                    cancelButtonText: "ຍົກເລີກ"
            }).then((result) => {
              
                if (result.isConfirmed) {
                    // proceed to delete
                    axios.delete('/api/product/delete/' + id, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                        if(response.data.success) {
                            this.$swal({
                                title: response.data.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2500,
                                toast: true,
                                position: 'top-end',
                            });
                            this.GetProduct(); // refresh product list
                        } else {
                            // show error message
                            this.$swal({
                                title: "ຜິດຜາດ!",
                                text: response.data.message,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 3500,
                            });
                        }
                    }).catch(error => {
                        console.log(error);
                        if(error && error.response && error.response.status === 401) {
                    
                            this.$swal({
                                title: "Token ໝົດອາຍຸ!",
                                text: "ກະລຸນາ Login ໃໝ່ອີກຄັ້ງ!",
                                icon: "error",
                                // showConfirmButton: false,
                                // timer: 3500,
                            }).then(() => {
                                console.log('Redirecting to login page...');
                                // clear token
                                this.store.logOut();
                                // clear local storage
                                localStorage.removeItem('web_token');
                                localStorage.removeItem('web_user');
                                // redirect to login page
                                this.$router.push('/login');
                            });
                        }
                    });
                } 
                             
            });

        },
      GetCategory(){
            // get category
            axios.get('/api/category', { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                this.CategoryData = response.data;
            }).catch(error => {
                console.log(error);
                if(error && error.response && error.response.status === 401) {
                    
                    this.$swal({
                        title: "Token ໝົດອາຍຸ!",
                        text: "ກະລຸນາ Login ໃໝ່ອີກຄັ້ງ!",
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3500,
                    }).then(() => {
                        console.log('Redirecting to login page...');
                        // clear token
                        this.store.logOut();
                        // clear local storage
                        localStorage.removeItem('web_token');
                        localStorage.removeItem('web_user');
                        // redirect to login page
                        this.$router.push('/login');
                    });
                }
            });
        },
        GetProduct(page = 1){

            // get product
            axios.get(`/api/product?page=${page}&sort=${this.Sort}&perpage=${this.PerPage}&category_id=${this.SelectCategory}&search=${this.Search}`, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                this.ProductData = response.data;
            }).catch(error => {
                console.log(error);
                if(error && error.response && error.response.status === 401) {
                    
                    this.$swal({
                        title: "Token ໝົດອາຍຸ!",
                        text: "ກະລຸນາ Login ໃໝ່ອີກຄັ້ງ!",
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3500,
                    }).then(() => {
                        console.log('Redirecting to login page...');
                        // clear token
                        this.store.logOut();
                        // clear local storage
                        localStorage.removeItem('web_token');
                        localStorage.removeItem('web_user');
                        // redirect to login page
                        this.$router.push('/login');
                    });
                }
            });

        }
    },
    watch:{
        // Sort 
        Sort() {
            this.GetProduct();
        },
        PerPage() {
            this.GetProduct();
        },
        SelectCategory() {
            this.GetProduct();
        },
        Search(val) {
            if(val.length === 0) {
                this.GetProduct();
            }
        }
    },
    created() {
        // Fetch initial data
        this.GetCategory();
        this.GetProduct();
    },
}
</script>
<style >
    .bimg {
        position: absolute;
    right: 15px;
    top: 10px;
    }
</style>