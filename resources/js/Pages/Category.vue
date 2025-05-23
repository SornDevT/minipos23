<template lang="">
<diV class="row">
        <div class="col-lg-6">
            <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h5 class="card-title">ໝວດໝູ່ສິນຄ້າ</h5>
            <button type="button" class="btn rounded-pill btn-icon btn-info" @click="AddCategory()">
                  <i class='bx bx-plus'  ></i> 
                </button>
        </div>
        <div class="card-body p-0">
                <!-- {{ CategoryData }} -->
                <!-- <button @click="showAlert">Hello world</button> -->
            <div class="list-group list-group-flush">
                  
                    <div v-for="item in CategoryData" :key="item.id" class="list-group-item list-group-item-action d-flex justify-content-between">
                        <span> {{ item.name }} </span>
                        <span> <i class='bx bx-edit cursor-pointer text-warning' @click="EditCategory(item.id)"  ></i> | <i class='bx  bx-trash cursor-pointer text-danger' @click="DeleteCategory(item.id)"  ></i> </span>
                    </div>
                    
                </div>

        </div>
        
    </div>
        </div>
</diV>

<div class="modal modal-top fade" id="FormCategory" tabindex="-1" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalTopTitle">ຟອມໝວດໝູ່</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col mb-6">
                            <label for="name_cat" class="form-label">ຊື່ໝວດໝູ່:</label>
                            <input type="text" id="name_cat" v-model="name" class="form-control" placeholder=".....">
                          </div>
                        </div>
                        
                      </div>
                      <div class="modal-footer">
                        
                        <button type="button" class="btn btn-primary" :disabled="CheckForm" @click="SaveCategory()" >ບັນທຶກ</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ປິດ</button>
                      </div>
                    </div>
                  </div>
                </div>

    
</template>
<script>
import { useStore } from "../Store/Auth"
export default {
    setup() {
        const store = useStore();
        return { store }
    },
    data() {
        return {
            name:'',
            FormType: true,
            EditID:'',
            CategoryData: [],
        }
    },
    computed: {
        
        CheckForm() {
            return this.name === '' ;
        }
    },
    methods: {
        showAlert() {
        // Use sweetalert2
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


    Swal.fire({
      title: "Deleted!",
      text: "Your file has been deleted.",
      icon: "success"
    });
  }
});
        },
        AddCategory(){
            $('#FormCategory').modal('show');
            this.FormType = true;
            this.name = '';
        },
        EditCategory(id){
            console.log(id);
            this.FormType = false;
            this.EditID = id;

            // get category by id
            axios.get('/api/category/edit/' + id, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                this.name = response.data.name;
                $('#FormCategory').modal('show');

            }).catch(error => {
                console.log(error);
            });

      
        },
        SaveCategory(){
            if(this.FormType){
                // save new category
                axios.post('/api/category/add', {
                    name: this.name,
                }, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                    if (response.data.success) {
                        this.name = '';
                        $('#FormCategory').modal('hide');
                        this.GetCategory(); // reload data
                        // reload data

                        this.$swal({
                            title: response.data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true,
                            position: 'top-end',
                        });

                    } else {
                        // show error message
                        $('#FormCategory').modal('hide');

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
                });
               
            }else{
                // update category
                
                axios.post('/api/category/update/' + this.EditID, {
                    name: this.name,
                }, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                    if (response.data.success) {
                        this.name = '';
                        $('#FormCategory').modal('hide');
                        this.GetCategory(); // reload data
                        // reload data

                        this.$swal({
                            title: response.data.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2500,
                            toast: true,
                            position: 'top-end',
                        });

                    } else {

                        $('#FormCategory').modal('hide');
                        // show error message
                        this.$swal({
                            title: "ຜິດຜາດ!",
                            text: response.data.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 6500,
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        DeleteCategory(id){
            // delete category


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

                        axios.delete('/api/category/delete/' + id, { headers:{ Authorization: 'Bearer ' + this.store.getToken } }).then(response => {
                            if (response.data.success) {
                                this.GetCategory(); // reload data

                                this.$swal({
                                    title: response.data.message,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 2500,
                                    toast: true,
                                    position: 'top-end',
                                });

                            } else {
                                // show error message

                                this.$swal({
                                        title: "ຜິດຜາດ!",
                                        text: response.data.message,
                                        icon: "error",
                                        showConfirmButton: false,
                                        timer: 6500,
                                    });

                            }
                        }).catch(error => {
                            console.log(error);
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
            });
        },

    },
    created() {
        this.GetCategory();
    },
}
</script>
<style lang="">
    
</style>