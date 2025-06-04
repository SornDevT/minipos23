<template lang="">
    <div class="card">
    <h5 class="card-header">ການເຄື່ອນໄຫວ ທຸລະກຳ</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center mb-2">
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
            </div>
            <div class="col-md-6 text-end mb-2">

                <div class="btn-group me-2" role="group" >
                  <button type="button" class="btn btn-secondary" @click="month_type='m'"> <i class='bx bx-chevron-right' v-if="month_type == 'm'"></i> ເດືອນ</button>
                  <button type="button" class="btn btn-secondary" @click="month_type='y'"> <i class='bx bx-chevron-right' v-if="month_type == 'y'"></i> ປີ</button>
                </div>

                <input type="date" v-model="dmy" class="form-control w-auto d-inline-block">
            </div>
        </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ລະຫັດ</th>
              <th>ວັນເວລາ</th>
              <th>ປະເພດ</th>
              <th>ລາຍລະອຽດ</th>
              <th>ຈຳນວນເງິນ</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in TransectionData.data" :key="item.tran_id">
              <td>{{ item.tran_id }}</td>
              <td>{{ date(item.created_at) }}</td>
              <td>{{ item.tran_type }}</td>
              <td>{{ item.detail }}</td>
              <td class="text-end">{{ formatPrice(item.price) }}</td>
              
            </tr>
          </tbody>
        </table>

         <Pagination :pagination="TransectionData" :offset="4" @paginate="GetTran($event)" />

      </div>
    </div>
  </div>
</template>
<script>
import { useStore } from "../Store/Auth";
import moment from 'moment';
export default {
    setup() {
        const store = useStore();
        return { store }
    },
    data() {
        return {
            Sort:'desc',
            PerPage: 10,
            month_type:'m',
            TransectionData: {
                data:[]
            },
            dmy: new Date().toISOString().split('T')[0], // Default to today's date
        }
    },
    components:{
        moment,
    },
    methods:{
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        date(vale){
            return moment(vale).format('DD/MM/YYYY');
        },
        GetTran(page=1){

            axios.get(`/api/transection?page=${page}&sort=${this.Sort}&per_page=${this.PerPage}&month_type=${this.month_type}&dmy=${this.dmy}`, {
                headers: {
                    Authorization: `Bearer ${this.store.token}`,
                }
            }).then(response => {

                    this.TransectionData = response.data;

            }).catch(error => {
                
                console.error("Error fetching transection data:", error);

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
    created() {
        this.GetTran();
    },
    watch: {
        PerPage() {
            this.GetTran();
        },
        Sort() {
            this.GetTran();
        },
        dmy() {
            this.GetTran();
        },
        month_type() {
            this.GetTran();
        }
    }
}
</script>
<style lang="">
    
</style>