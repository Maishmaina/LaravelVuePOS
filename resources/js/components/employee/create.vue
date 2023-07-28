<template>
	<div>
		<div class="row">
			<router-link to="/employee" class="btn btn-info btn-sm"><i class="fa fa-arrow-left mr-1"></i> All Employees</router-link>
		</div>
	<div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-9">
        <div class="card shadow-sm my-3">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Employee</h1>
                  </div>
                  <form class="user" @submit.prevent="create_employee" enctype="multipart/form-data">
                  	<div class="form-group">
                  		<div class="form-row">
                  			<div class="col-md-6">
                  				<input 
                      type="text" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter Full Name"
                      v-model="form.name"
                      >
                  			</div>
                  			<div class="col-md-6">
                  				<input 
                      type="email" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter Email"
                      v-model="form.email"
                      >
                  			</div>
                  		</div>
                  	</div>
                  	<div class="form-group">
                  		<div class="form-row">
                  			<div class="col-md-6">
                  				<input 
                      type="text" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter Address"
                      v-model="form.address"
                      >
                  			</div>
                  			<div class="col-md-6">
                  				<input 
                      type="number" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter Salary"
                      v-model="form.salary"
                      >
                  			</div>
                  		</div>
                  	</div>

                  	<div class="form-group">
                  		<div class="form-row">
                  			<div class="col-md-6">
                  				<input 
                      type="date" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter Date of Employement"
                      v-model="form.joining_date"
                      >
                  			</div>
                  			<div class="col-md-6">
                  				<input 
                      type="number" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter National ID"
                      v-model="form.nid"
                      >
                  			</div>
                  		</div>
                  	</div>

                  	<div class="form-group">
                  		<div class="form-row">
                  			<div class="col-md-6">
                  				<input 
                      type="text" 
                      class="form-control"
                      id="exampleInputFirstName" 
                      placeholder="Enter Phone Number"
                      v-model="form.phone"
                      >
                  			</div>
                  			<div class="col-md-6">
                  			
                  			</div>
                  		</div>
                  	</div>

                  	 <div class="form-group">
                  		<div class="form-row">
                  			<div class="col-md-6">
                  				<label class="custom-file-label" for="customFile">Choose file</label>
                  				<input 
                      type="file" 
                      class="custom-file-input"
                      id="customFile" 
                      @change="onFileSelected"
                      >
                  			</div>
                  			<div class="col-md-6">

                  				<img :src="form.photo"  style="height:50px; width: 50px;" />
                  			
                  			</div>
                  		</div>
                  	</div>



                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                    
                    </form>
                  <hr>
                  
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
</template>

<script>
  export default{
      data(){
    return{
      form:{
        name:null,
        phone:null,
        email:null,
        salary:null,
        address:null,
        photo:null,
        nid:null,
        joining_date:null,
      },
      errors:{},
    }
  },
  created(){
    if (!User.loggedIn()){
      this.$router.push({name: '/'})
    }
  },
  methods:{
  	onFileSelected(event){
  		let file=event.target.files[0];
  		if(file.size >1048770){
  			Notification.image_validation();
  		}else{

  			let reader= new FileReader();
  			reader.onload= event=>{
  				this.form.photo= event.target.result;
  				console.log(event.target.result);
  			}
  			reader.readAsDataURL(file);

  		}

  	},
  	create_employee(){
  		axios.post('/api/employee',this.form)
  		.then(()=>{
  			Notification.success();
  			this.$router.push({name: 'employee'});
  		})
  		.catch(error => console.log(error.response.data.errors))
  		.catch(error =>Notification.error())
  	},
  }
  }

</script>

<style></style>