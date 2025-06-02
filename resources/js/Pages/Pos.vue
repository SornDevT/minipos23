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
                        <input type="text" class="form-control mb-2" v-model="customer_name" placeholder="ຊື່ລູກຄ້າ" >
                        <label>ເບີໂທ:</label>
                        <input type="text" class="form-control mb-2" v-model="customer_tel" placeholder="ເບີໂທ" >
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
                        <button type="button" class="btn rounded-pill btn-success w-100" @click="showConfirm()" >ຊຳລະເງີນ</button>
                    </diV>
                </div>
            </div>
        </div>


            <div class="modal fade" id="sh_showconfirm" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="backDropModalTitle">ການຊຳລະເງິນ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ formatPrice(TotalPrice) }} ກີບ</span>
                            </div>
                            <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-TotalPrice)>0">
                                <span>ເງິນທອນ:</span>
                                <span>{{ formatPrice(CashAmount-TotalPrice) }} ກີບ</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <label>ຮັບເງິນນຳລູກຄ້າ</label>
                            <cleave :options="options" v-model="CashAmount" class=" form-control text-end" />
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <!-- <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button> -->
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-danger w-100"  @click="CashAmount = TotalPrice">{{formatPrice(TotalPrice)}}</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(1000)">1,000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(2000)" >2,000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(5000)">5,000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(10000)">10,000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(20000)" >20,000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(50000)">50,000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(100000)" >100,000</button>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-primary me-2" :disabled="CheckBTPay" @click="Confirm_Pay()" >ບັນທຶກ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
                      </div>
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
            CashAmount: 0,
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: '.',
                  delimiter: ','
                },
            customer_name: '',
            customer_tel: '',
        }
    },
    computed: {
        CheckBTPay() {
            // check if CashAmount is less than TotalPrice
            return parseInt(this.CashAmount) < parseInt(this.TotalPrice);
        },
        // sum of all items in ListOrder
        TotalPrice() {
            return this.ListOrder.reduce((total, item) => {
                return total + (item.price * item.qty);
            }, 0);
        },
    },
    methods:{
        async openLink(link){
            const response = await fetch(`${link}`,{ headers:{ Authorization: 'Bearer '+ this.store.getToken}});
            const html = await response.text();
            const blob = new Blob([html],{ type: "text/html"});
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl, "_blank");
        },
        Confirm_Pay(){

            axios.post('/api/transection/add',{
                customer_name: this.customer_name,
                customer_tel: this.customer_tel,
                listorder: this.ListOrder,
            }, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                
                $('#sh_showconfirm').modal('hide');

                if(response.data.success){
                    // clear list order
                    this.ListOrder = [];
                    // clear customer name and tel
                    this.customer_name = '';
                    this.customer_tel = '';
                    // clear cash amount
                    this.CashAmount = 0;
                    // show success message
                    this.$swal({
                            title: response.data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true,
                            position: 'top-end',
                        });

                    // print receipt
                    // window.open('api/bill/print/'+response.data.bill_id, '_blank');
                    this.openLink('api/bill/print/'+response.data.bill_id);

                    // get product again
                    this.GetProduct();
                
                } else {
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
        AddNum(num){
            this.CashAmount = parseInt(this.CashAmount?this.CashAmount:0) + parseInt(num);
        },
        showConfirm(){
            this.CashAmount = 0;
            $('#sh_showconfirm').modal('show');
        },
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