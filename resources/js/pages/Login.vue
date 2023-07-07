
<template>
    
<div class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a class="h1"><b>Sign In</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

        <div class="input-group mb-3">
          <input type="email" v-model="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" v-model="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" @click="loginBtn">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
</div>



</template>


<script>
import { useToastr } from '../toastr.js'
import store from '../store.js'


export default{
    data:() => ({
    email: '',
    password: '',
}),
methods:{
    useToastr,
    async loginBtn(){
        let data = {
          'email': this.email,
          'password': this.password,
                  };
            await this.axios.post(this.$store.state.apiLogin, data).then(res =>{
              if(res.data != 'failed'){
                this.$router.push('/');
                store.commit('setUser', {stateOfUser: res.data});
              this.useToastr().success('Login Was Successfull');
              }else{
                this.useToastr().error('Email Or Password Is Wrong');
              }
                // store.commit('setUser', {stateOfUser: res.data.userName});
              // this.email = '';
              // this.password = '';
            //   this.$router.push('/');
      }).catch((error)=>{
        this.useToastr().error('Email Or Password Is Wrong');
      });
    }
}
}
</script>
