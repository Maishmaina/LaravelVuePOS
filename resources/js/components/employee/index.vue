<template>
	<div>
		<div class="row">
			<router-link to="/store-employee" class="btn btn-info btn-sm"><i class="fa fa-arrow-left mr-1"></i> Add Employee</router-link>
		</div>
 <br/>
    <input 
    type="text" 
    class="form-control"
    placeholder="Search" 
    v-model="searchTerm"
    style="width:300px;">
   
    <div class="row my-3">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">All Employees</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone Number</th>
                        <th>Salary</th>
                        <th>Address</th>
                        <th>Joining Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                     <tr v-for="employee in filtersearch" :key="employee.id">
                        <td>{{employee.id}}</td>
                        <td>{{employee.name}}</td>
                        <td><img :src="employee.photo" id="em_photo"/></td>
                        <td>{{employee.phone}}</td>
                        <td>{{employee.salary}}</td>
                        <td>{{employee.address}}</td>
                        <td>{{employee.joining_date}}</td>
                        <td>
                          <div class="btn-group">
                          <router-link :to="{name: 'edit-employee', params:{id:employee.id} }" class="btn btn-sm btn-primary" title="Edit User"><i class="fa fa-edit"></i></router-link>
                          <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger text-white" title="Delete User"><i class="fa fa-trash"></i></a></div>
                        </td>
                      </tr>                  
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
	</div>
</template>

<script>
  export default{
    data(){
      return{

        employees:[],
        searchTerm:'',
      }
    },
  computed:{
    filtersearch(){
      return this.employees.filter(employee=>{
        return employee.phone.match(this.searchTerm)
      })
    }
  },  
  created(){
    if (!User.loggedIn()){
      this.$router.push({name: '/'})
    }
    this.AllEmployee();

    

  },
  methods:{
  	AllEmployee(){
      axios.get('/api/employee')
      .then((data)=>{
        this.employees=data.data;
        console.log(data.data);
        })
      .catch()
  	},
    deleteEmployee(id){
      Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                axios.delete('/api/employee/'+id)
               .then(() => {
                this.employees = this.employees.filter(employee => {
                  return employee.id != id
                })
               })
               .catch(() => {
                this.$router.push({name: 'employee'})
               })
                Swal.fire(
                  'Deleted!',
                  'Your record has been deleted.',
                  'success'
                )
              }
            })
    }
  }

  }

</script>

<style>
  #em_photo{
    height: 50px;
    width: 50px;
  }
</style>