<template lang="">
    <div class="card">
    <h5 class="card-header">ລາຍການສິນຄ້າທັງໝົດ</h5>
    <div class="card-body">

        <div class="row">
            <div class="col-lg-6 d-flex mb-2 align-items-center">

                <span class="me-2">
                    <i class='bx bx-sort-down fs-4'></i>
                </span>

                <select class="form-select w-auto me-2" >
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                </select>

                <select class="form-select w-auto" >
                <option value="10">ທັງໝົດ</option>
                <option value="20">20</option>
                <option value="30">30</option>
                </select>

            </div>
            <div class="col-lg-6 mb-2 d-flex justify-content-end">

                <div class="input-group w-auto me-2">
                    <input type="text" class="form-control" placeholder="ຄົ້ນຫາ...." >
                    <button class="btn btn-primary px-3" type="button"><i class='bx bx-search-alt'></i></button>
                </div>
                <button type="button" class="btn btn-info">ເພີ່ມໃໝ່</button>
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
          <tbody v-if="ProductData.length > 0">
            <tr>
            </tr>
          </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7" class="text-center"> <i class='bx bxs-data'></i> ບໍ່ມີຂໍໍ່ມູນ</td>
                </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    
    data(){
        return {
            name:'',
            FormType: true,
            EditID:'',
            CategoryData: [],
            ProductData:[],
        }
    }
}
</script>
<style lang="">
    
</style>