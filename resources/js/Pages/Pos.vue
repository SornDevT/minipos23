<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body d-flex">
                    <select class="form-select w-auto me-2" v-model="SelectCategory">
                        <option value="all">ທັງໝົດ</option>
                        <option :value="item.id" v-for="item in CategoryData" :key="item.id"> {{ item.name }} </option>
                    </select>

                    <div class="input-group">
                        <input type="text" class="form-control" v-model="Search" placeholder="ຄົ້ນຫາ...." @keyup.enter="GetProduct()" >
                        <button class="btn btn-primary px-3" type="button" @click="GetProduct()" ><i class='bx bx-search-alt'></i></button>
                    </div>
                </div>

            </div>
            
            <PerfectScrollbar>
            <div class="row" style="height: 65vh; ">
                    <div class="col-md-3 mb-3" v-for="item in ProductData.data" :key="item.id">
                        <div class="card cursor-pointer" @click="AddToOrder(item.id)">
                            <!-- <span class="box-num">10</span> -->
                            <span v-for="list in ListOrder" :key="list.id" >
                                <span v-if="list.id === item.id" class="box-num">{{ list.qty }}</span>
                            </span>
                            <span v-if="item.qty === 0" class="box-out-of-store">ສິນຄ້າໝົດ</span>
                            <img v-if="item.image" class="card-img-top img-box" :src="url + '/assets/img/products/'+item.image" >
                            <img v-else class="card-img-top img-box" :src="url + '/assets/img/no-image.jpg'" >
                            <div class="card-body p-1 text-center">
                            <h5 class="card-title">{{ limitWord(item.name) }}</h5>
                            <p class="card-text text-center">{{ formatPrice(item.price_sell) }} ກີບ</p>
                          
                            </div>
                        </div>
                    </div>
            </div>
            </PerfectScrollbar>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <label>ຊື່ລູກຄ້າ:</label>
                        <input type="text" class="form-control mb-2" placeholder="ຊື່ລູກຄ້າ" >
                        <label>ເບີໂທ:</label>
                        <input type="text" class="form-control mb-2" placeholder="ເບີໂທ" >
                    </div>
                    <div class=" p-3 bg-info text-white text-center">
                        ລາຍການສັ່ງຊື້
                    </div>
                    <PerfectScrollbar>
                    <div style="height: 39vh;">
                        <!-- {{ListOrder}} -->
                        <table class="table table-bordered mb-0">
                        
                            <tbody>
                                <tr v-for="item in ListOrder" :key="item.id">
                                    <td class="p-1">
                                        <div class=" d-flex">
                                            <img v-if="item.image" :src="url + '/assets/img/products/'+item.image" class="list-img-order" >
                                            <img v-else :src="url + '/assets/img/no-image.jpg'" class="list-img-order" >
                                            <div class=" w-100 px-2">
                                               <div> {{item.name}} </div>
                                               <div class="text-end"> {{formatPrice(item.qty)}} x {{formatPrice(item.price)}} </div>
                                               <div class="d-flex justify-content-between align-items-center"> 
                                                    <span>
                                                        <i class='bx bxs-plus-circle text-success cursor-pointer' @click="AddToOrder(item.id)"></i> | <i class='bx bxs-minus-circle text-warning cursor-pointer' @click="RemoveItemList(item.id)"></i> | <i class='bx bxs-trash text-danger cursor-pointer' @click="DeleteItemList(item.id)"></i>
                                                    </span>
                                                    <span>{{formatPrice(item.qty*item.price)}}</span>
                                                 </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </PerfectScrollbar>
                    <div class=" p-3 bg-info text-white d-flex justify-content-between align-items-center">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalPrice) }}</span>
                    </div>
                    <diV class="p-2">
                        <button type="button" class="btn rounded-pill btn-success w-100">ຊຳລະເງີນ</button>
                    </diV>
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
    data() {
        return {
            url: window.location.origin,
            Search: '',
            Sort:'asc',
            PerPage: 50,
            CategoryData: [],
            ProductData:{
              data: [],
            },
            SelectCategory: 'all',
            ListOrder: [],
        }
    },
    computed: {
        // sum of all items in ListOrder
        TotalPrice() {
            return this.ListOrder.reduce((total, item) => {
                return total + (item.price * item.qty);
            }, 0);
        },
    },
    methods:{
        // limit word 
        limitWord(text, limit = 15) {
            if (text.length > limit) {
                return text.substring(0, limit) + '...';
            }
            return text;
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        AddToOrder(id){
            // get product by id
            let item = this.ProductData.data.find(item => item.id === id);

            // get list order by id
            let orderItem = this.ListOrder.find(item => item.id === id);

            if(item.qty <= 0) {
                this.$swal({
                    title: "ສິນຄ້າບໍ່ມີໃນສະຕ໋ອກ!",
                    text: "ກະລຸນາເລືອກສິນຄ້າອື່ນ!",
                    icon: "warning",
                });
                return;
            }

            // check if qty of list order is greater than qty of product
            if(orderItem && orderItem.qty >= item.qty) {
                this.$swal({
                    title: "ສິນຄ້າບໍ່ພໍ!",
                    text: "ກະລຸນາເລືອກສິນຄ້າອື່ນ!",
                    icon: "warning",
                });
                return;
            }

            // if item already in order list, increase qty
            if(orderItem) {
                orderItem.qty += 1;
       
            } else {
                // add to order list
                this.ListOrder.push({
                    id: item.id,
                    name: item.name,
                    price: item.price_sell,
                    image: item.image,
                    qty: 1, 
                });
            }

            
        },
        RemoveItemList(id) {
            // minus qty of item in order list
            let orderItem = this.ListOrder.find(item => item.id === id);
            if(orderItem) {
                if(orderItem.qty > 1) {
                    orderItem.qty -= 1;
                } else {
                    // remove item from order list
                    this.ListOrder = this.ListOrder.filter(item => item.id !== id);
                }
            }
        },
        DeleteItemList(id) {
            // remove item from order list
            this.ListOrder = this.ListOrder.filter(item => item.id !== id);
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
    },
    watch: {
        SelectCategory() {
            this.GetProduct();
        },
        Search(val) {
            if(val.length === 0) {
                this.GetProduct();
            }
        },
    },
    created() {
        // get product
        this.GetProduct();
        // get category
        this.GetCategory();
    },
}
</script>
<style >
    .img-box {
        height: 110px;
        object-fit: cover;
        object-position: center;
    }
    .box-num{
        position: absolute;
        background-color: #ff00006e;
        width: 100%;
        top: 40px;
        text-align: center;
        padding: 5px;
        color: white;
        font-size: 18px;
        font-weight: bold;
    }
    .list-img-order {
    width: 80px;
    height: 70px;
    object-fit: cover;
    object-position: center;
    border-radius: 5px;
    padding: 2px;
    border: 1px solid #dadada;
    }

    .box-out-of-store{
        position: absolute;
        background-color: #1f1e1e6e;
        width: 100%;
        top: 40px;
        text-align: center;
        padding: 5px;
        color: #f7f7f7;
        font-size: 18px;
        font-weight: bold;
    }
</style>