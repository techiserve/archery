@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Create Archer</h5>
                <form class="card-body"  method="POST" action="/archers/store">
                @csrf
                  <h6>1. Archer Details</h6>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-email">Surname</label>
                      <div class="input-group input-group-merge">
                        <input
                          type="text"
                          name="surname" 
                          id="multicol-email"
                          class="form-control"
                          placeholder="Surname"
                          aria-label="john.doe"
                          aria-describedby="multicol-email2" />
                        <span class="input-group-text" id="multicol-email2"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-password">Date of Birth</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="date"
                            name="dob" 
                            id="dob"
                            onchange="calculateAgeDetails()" 
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-password2"
                            ></span>
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Age Group</label>
                      <input type="text" id="ageCategory"  class="form-control"  name="ag" readonly>
                    </div>

              
                  </div>
                 </br>
                  <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Grading Dominant</label>
                      <select class="form-select" id="cgdSelect" name="cgd" aria-label="Default select example">
                           <option value="SC1">SC1</option>   
                           <option value="SC2">SC2</option>
                           <option value="SC3">SC3</option>  
                           <option value="SJ1">SJ1</option>   
                           <option value="SJ2">SJ2</option>
                           <option value="SJ3">SJ3</option>  
                           <option value="SA1">SA1</option>   
                           <option value="SA2">SA2</option>
                           <option value="SA3">SA3</option> 

                           <option value="AC1">AC1</option>   
                           <option value="AC2">AC2</option>
                           <option value="AC3">AC3</option>  
                           <option value="AJ1">AJ1</option>   
                           <option value="AJ2">AJ2</option>
                           <option value="AJ3">AJ3</option>  
                           <option value="AA1">AA1</option>   
                           <option value="AA2">AA2</option>
                           <option value="AA3">AA3</option> 

                           <option value="MC1">MC1</option>   
                           <option value="MC2">MC2</option>
                           <option value="MC3">MC3</option>  
                           <option value="MJ1">MJ1</option>   
                           <option value="MJ2">MJ2</option>
                           <option value="MJ3">MJ3</option>  
                           <option value="MA1">MA1</option>   
                           <option value="MA2">MA2</option>
                           <option value="MA3">MA3</option> 
                     </select>
                    </div>
                   
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Grading Weak</label>
                      <select class="form-select" id="cgwSelect" name="cgw" aria-label="Default select example">
                           <option value="SC1">SC1</option>   
                           <option value="SC2">SC2</option>
                           <option value="SC3">SC3</option>  
                           <option value="SJ1">SJ1</option>   
                           <option value="SJ2">SJ2</option>
                           <option value="SJ3">SJ3</option>  
                           <option value="SA1">SA1</option>   
                           <option value="SA2">SA2</option>
                           <option value="SA3">SA3</option> 

                           <option value="AC1">AC1</option>   
                           <option value="AC2">AC2</option>
                           <option value="AC3">AC3</option>  
                           <option value="AJ1">AJ1</option>   
                           <option value="AJ2">AJ2</option>
                           <option value="AJ3">AJ3</option>  
                           <option value="AA1">AA1</option>   
                           <option value="AA2">AA2</option>
                           <option value="AA3">AA3</option> 

                           <option value="MC1">MC1</option>   
                           <option value="MC2">MC2</option>
                           <option value="MC3">MC3</option>  
                           <option value="MJ1">MJ1</option>   
                           <option value="MJ2">MJ2</option>
                           <option value="MJ3">MJ3</option>  
                           <option value="MA1">MA1</option>   
                           <option value="MA2">MA2</option>
                           <option value="MA3">MA3</option> 
                     </select>
                    </div>
                    </div>  
                    </br>
                   
                    <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Current Proficiency</label>
              
                      <select class="form-select" id="exampleFormControlSelect1" name="cp" aria-label="Default select example">
                           <option value="SC1">SC1</option>   
                           <option value="SC2">SC2</option>
                           <option value="SC3">SC3</option>  
                           <option value="SJ1">SJ1</option>   
                           <option value="SJ2">SJ2</option>
                           <option value="SJ3">SJ3</option>  
                           <option value="SA1">SA1</option>   
                           <option value="SA2">SA2</option>
                           <option value="SA3">SA3</option> 

                           <option value="AC1">AC1</option>   
                           <option value="AC2">AC2</option>
                           <option value="AC3">AC3</option>  
                           <option value="AJ1">AJ1</option>   
                           <option value="AJ2">AJ2</option>
                           <option value="AJ3">AJ3</option>  
                           <option value="AA1">AA1</option>   
                           <option value="AA2">AA2</option>
                           <option value="AA3">AA3</option> 

                           <option value="MC1">MC1</option>   
                           <option value="MC2">MC2</option>
                           <option value="MC3">MC3</option>  
                           <option value="MJ1">MJ1</option>   
                           <option value="MJ2">MJ2</option>
                           <option value="MJ3">MJ3</option>  
                           <option value="MA1">MA1</option>   
                           <option value="MA2">MA2</option>
                           <option value="MA3">MA3</option> 
                     </select> 
           
                    </div>
                   
                 

                    <div class="col-md-6">
                      <div class="form-password-toggle">
                        <label class="form-label" for="multicol-confirm-password">Email</label>
                        <div class="input-group input-group-merge">
                          <input
                            type="email"
                            name="email" 
                            id="multicol-confirm-password"
                            class="form-control"
                            placeholder=""
                            aria-describedby="multicol-confirm-password2" />
                          <span class="input-group-text cursor-pointer" id="multicol-confirm-password2"
                            ><i class=""></i
                          ></span>
                        </div>
                      </div>
                    </div>
                    </div>  
                    </br>
                    <div class="row g-6">
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Age Group Proficiency</label>
                      <input type="text" id="ageGroup"  class="form-control"  name="agp" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="multicol-first-name">Dominant Hand</label>
                      <select class="form-select" id="exampleFormControlSelect1" name="dh" aria-label="Default select example">
 
                           <option value="Left">Left</option>
                           <option value="Right">Right</option>  
                     </select>
                    </div>

                  </div>

                  
                  <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div>
                </form>
              </div>

       
             
</div>
@endsection
<script>
    function calculateAgeDetails() {
        const dobInput = document.getElementById("dob").value;
        const ageCategoryInput = document.getElementById("ageCategory");
        const ageGroupInput = document.getElementById("ageGroup");
        const cgdSelect = document.getElementById("cgdSelect");
        const cgwSelect = document.getElementById("cgwSelect");

        if (!dobInput) return;

        const dob = new Date(dobInput);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        let yearOfLiving = today.getFullYear() - dob.getFullYear() + 1;

        let category = "";
        if (age >= 5 && age <= 12) {
            category = "Cub";
        } else if (age >= 13 && age <= 16) {
            category = "Junior";
        } else if (age >= 17) {
            category = "Adult";
        } else {
            category = "Too Young";
        }

        let proficiency = "";
        if (yearOfLiving >= 5 && yearOfLiving <= 12) {
            proficiency = "Cub";
        } else if (yearOfLiving >= 13 && yearOfLiving <= 16) {
            proficiency = "Junior";
        } else if (yearOfLiving >= 17) {
            proficiency = "Adult";
        } else {
            proficiency = "Too Young";
        }

        ageCategoryInput.value = category;
        ageGroupInput.value = proficiency;

        const optionsByCategory = {
    "Cub": ["SC1", "SC2", "SC3", "AC1", "AC2", "AC3","MC1",  "MC2", "MC3"],
    "Junior": ["SJ1", "SJ2", "SJ3","AJ1",  "AJ2", "AJ3","MJ1",  "MJ2", "MJ3"],
    "Adult": ["SA1", "SA2", "SA3", "AA1", "AA2", "AA3", "MA1", "MA2", "MA3"]
};

        // Helper to populate dropdown options
        function populateOptions(selectElement, category) {
            selectElement.innerHTML = "";

            if (optionsByCategory[category]) {
                optionsByCategory[category].forEach(value => {
                    const option = document.createElement("option");
                    option.value = value;
                    option.text = value;
                    selectElement.appendChild(option);
                });
            } else {
                const option = document.createElement("option");
                option.value = "";
                option.text = "N/A";
                selectElement.appendChild(option);
            }
        }

        // Update both selects
        populateOptions(cgdSelect, category);
        populateOptions(cgwSelect, category);
    }
</script>
