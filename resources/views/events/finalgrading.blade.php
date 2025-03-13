@extends('template.default')
<style>
    .table-responsive {
    overflow-x: auto;
}

.sticky-col {
    position: sticky;
    left: 0;
    background-color: white; /* Ensure background covers scrolling content */
    z-index: 2;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Optional: Adds a shadow effect */
}
</style>
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
                <h5 class="card-header">Score Card</h5>
                <form class="card-body"  method="POST" action="/grading/confirmscores">
                @csrf
                <h6> Event Details</h6>
                  <div class="row g-12">
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Name</label>
                      <input type="text" id="multicol-username" name="name" value="{{$name}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Date</label>
                      <input type="text" id="multicol-username" name="date"  value="{{$date}}" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-md-4">
                    
                      <label class="form-label" for="multicol-username">Event Category</label>
                      <input type="text" id="multicol-username" name="eventcategory"  value="{{$eventcategory}}" class="form-control" placeholder="John Doe" />
                    </div>
                    
                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Bow Used</label>
                      <input type="text" id="multicol-username" name="bowused"  value="{{$bowused}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <label class="form-label" for="multicol-username">Current Grading</label>
                      <input type="text" id="multicol-username" name="curentgrading"  value="{{$curentgrading}}"  class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-email">Grading for </label>
                   
                      <input type="text" id="multicol-username" name="gradefor"  value="{{$gradefor}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                    <label class="form-label" for="multicol-username">Age Category</label>
                    <input type="text" id="multicol-username" name="age"  value="{{$age}}" class="form-control" placeholder="John Doe" />
                    </div>

                    <div class="col-md-4">
                      <div class="form-password-toggle">
                      <label class="form-label" for="multicol-username">Arrow Used</label>
                      <input type="text" id="multicol-username" name="arrow"  value="{{$arrow}}" class="form-control" placeholder="John Doe" />
                      </div>
                    </div>
            
                    
                    <input type="hidden" name="event" value="{{$event}}">
                    <input type="hidden" name="archer" value="{{$archer}}">
                    <input type="hidden" name="figure" value="{{$figure}}">
          
                  <!-- <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-3">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                  </div> -->
                <!-- </form> -->
              </div>
                        
</div>


    <!-- DataTable with Checkboxes -->
    <!-- <div class="card">
        <div class="card-datatable text-nowrap">
        <div class="table-responsive">
            <table class="datatables-basic table table-bordered table-responsive">
                <thead>
                    <tr>
                       
                        <th></th>
                        <th>Arrow 1</th>
                        <th>Arrow 2</th>
                        <th>Arrow 3</th>
                        <th>Arrow 4</th>
                        <th>Arrow 5</th>
                        <th>Arrow 6</th>
                        <th>Round Total</th>
                        <th>Cum Total</th>
                        <th>Event Time</th>
                        <th>Current P/R</th>
                        <th>Required P/R</th>
                    </tr>
                </thead>
                <tbody>
                   
               <tr>
                        <td>Round 1</td>
                        <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field11" id="field11" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field12" id="field12" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field13" id="field13" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field14" id="field14" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field15" id="field15" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field16" id="field16" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total" id="total" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text" name="cumtotalfirst" id="cumtotalfirst" class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>

                      <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="current" id="current" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="required" id="required" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
              </tr>

               <tr>
                    <td>Round 2</td>
                    <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field21" id="field21" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field22" id="field22" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field23" id="field23" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field24" id="field24" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field25" id="field25" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field26" id="field26" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total2" id="total2" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text" name="cumtotal2" id="cumtotal2"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" name="time2" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
             </tr>
                
             <tr>
                   <td>Round 3</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field31" id="field31" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field32" id="field32" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field33" id="field33" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field34" id="field34" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field35" id="field35" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field36" id="field36" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total3" id="total3" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text" name="cumtotal3" id="cumtotal3"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
            <tr>
                   <td>Round 4</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field41" id="field41" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field42" id="field42" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field43" id="field43" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field44" id="field44" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field45" id="field45" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field46" id="field46" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total4" id="total4" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text"   name="cumtotal4" id="cumtotal4"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
            <tr>
                   <td>Round 5</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field51" id="field51" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field52" id="field52" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field53" id="field53" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field54" id="field54" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field55" id="field55" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field56" id="field56" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total5" id="total5" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text"  name="cumtotal5" id="cumtotal5"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
            </tr>
                
            <tr>
                   <td>Round 6</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field61" id="field61" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field62" id="field62" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field63" id="field63" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field64" id="field64" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field65" id="field65" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field66" id="field66" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total6" id="total6" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text"  name="cumtotal6" id="cumtotal6"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
            <tr>
                   <td>Round 7</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field71" id="field71" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field72" id="field72" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field73" id="field73" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field74" id="field74" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field75" id="fiel715" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field76" id="field76" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total7" id="total7"    class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text"  name="cumtotal7" id="cumtotal7"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
          </tr>
                
           <tr>
                   <td>Round 8</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field81" id="field81" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field82" id="field82" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field83" id="field83" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field84" id="field84" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field85" id="field85" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field86" id="field86" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total8" id="total8" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text"  name="cumtotal8" id="cumtotal8"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
           </tr>
                
           <tr>
                   <td>Round 9</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field91" id="field91" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field12" id="field12" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field13" id="field13" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field14" id="field14" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field15" id="field15" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field16" id="field16" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total9" id="total9" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"><input type="text"  name="cumtotal9" id="cumtotal9"  class="form-control dt-input dt-full-name" /></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"><input type="text" class="form-control" placeholder="HH:MM" id="flatpickr-time" /></div></td>
         </tr>

         <tr>
                   <td>Total</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="grandtotal" id="grandtotal" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"></div></td>
         </tr>
        
                </tbody>
            </table>
        </div>
       </div>
    </div> -->



<!-- the refined table structure -->

    <div class="card">
        <div class="card-datatable text-nowrap">
        <div class="table-responsive">
            <table class="datatables-basic table table-bordered table-responsive">
                <thead>
                    <tr>
                       
                        <th></th>
                        <th>Round 1</th>
                        <th>Round 2</th>
                        <th>Round 3</th>
                        <th>Round 4</th>
                        <th>Round 5</th>
                        <th>Round 6</th>
                        <th>Round 7</th>
                        <th>Round 8</th>
                        <th>Round 9</th>
                 
                    </tr>
                </thead>
                <tbody>
                   
               <tr>
                        <td>Arrow 1</td>
                        <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field11" id="field11" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field21" id="field21" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field31" id="field31" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field41" id="field41" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>

                   
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field51" id="field51" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field61" id="field61" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>

                  
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field71" id="field71" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>

                     
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" name="field81" id="field81" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>

               
                </div></td>
                      
                      <td>
                        <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field91" id="field91" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>

                      
                        </div></td>

                      <!-- <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="current" id="current" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="required" id="required" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td> -->
              </tr>

               <tr>
                    <td>Arrow 2</td>
                    <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field12" id="field12" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field22" id="field22" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field32" id="field32" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field42" id="field42" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field52" id="field52" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field62" id="field62" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field72" id="field72" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>

                      
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" name="field82" id="field82" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                
                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" name="field92" id="field92" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
  
                        
                    </div></td>
             </tr>
                
             <tr>
                   <td>Arrow 3</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                        
                    <input type="text" name="field13" id="field13" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field23" id="field23" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field33" id="field33" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field43" id="field43" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field53" id="field53" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field63" id="field63" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        
                    <input type="text" name="field73" id="field73" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>

                     
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" name="field83" id="field83" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>

                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" name="field93" id="field93" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>

                    </div></td>
           </tr>
                
            <tr>
                   <td>Arrow 4</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field14" id="field14" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>
                    
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field24" id="field24" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field34" id="field34" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field44" id="field44" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field54" id="field54" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>

            
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field64" id="field64" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field74" id="field74" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>
                     
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" name="field84" id="field84" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>
                 
                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" name="field94" id="field94" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>
                   
                    </div></td>
           </tr>
                
            <tr>
                   <td>Arrow 5</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field15" id="field15" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field25" id="field25" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field35" id="field35" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field45" id="field45" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field55" id="field55" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field65" id="field65" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field75" id="fiel75" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>

                     
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" name="field85" id="field85" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>

                    
                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" name="field95" id="field95" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>

         
                    </div></td>
            </tr>
                
            <tr>
                   <td>Arrow 6</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field16" id="field16" class="form-control dt-input dt-full-name input-number" oninput="calculateTotal()" required/>

                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field26" id="field26" class="form-control dt-input dt-full-name input-number-2" oninput="calculateTotal2()" required/>

                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field36" id="field36" class="form-control dt-input dt-full-name input-number-3" oninput="calculateTotal3()" required/>

                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field46" id="field46" class="form-control dt-input dt-full-name input-number-4" oninput="calculateTotal4()" required/>

                   
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field56" id="field56" class="form-control dt-input dt-full-name input-number-5" oninput="calculateTotal5()" required/>

                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="field66" id="field66" class="form-control dt-input dt-full-name input-number-6" oninput="calculateTotal6()" required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="field76" id="field76" class="form-control dt-input dt-full-name input-number-7" oninput="calculateTotal7()" required/>

                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                    <input type="text" name="field86" id="field86" class="form-control dt-input dt-full-name input-number-8" oninput="calculateTotal8()" required/>

                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" name="field96" id="field96" class="form-control dt-input dt-full-name input-number-9" oninput="calculateTotal9()" required/>

                    </div></td>
           </tr>
                
            <tr>
                   <td>Round Total</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="total" id="total" class="form-control dt-input dt-full-name" readonly required/>
                    
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="total2" id="total2" class="form-control dt-input dt-full-name" readonly required/>
                  
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="total3" id="total3" class="form-control dt-input dt-full-name" readonly required/>
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="total4" id="total4" class="form-control dt-input dt-full-name" readonly required/>
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="total5" id="total5" class="form-control dt-input dt-full-name" readonly required/>
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="total6" id="total6" class="form-control dt-input dt-full-name" readonly required/>
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        <input type="text" name="total7" id="total7"    class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" name="total8" id="total8" class="form-control dt-input dt-full-name" readonly required/>
                 
                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" name="total9" id="total9" class="form-control dt-input dt-full-name" readonly required/>
                     
                    </div></td>
          </tr>
                
           <tr>
                   <td>Cum Total </td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="cumtotalfirst" id="cumtotalfirst" class="form-control dt-input dt-full-name" />
                      
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="cumtotal2" id="cumtotal2"  class="form-control dt-input dt-full-name" />
                       
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="cumtotal3" id="cumtotal3"  class="form-control dt-input dt-full-name" />
                  
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text"   name="cumtotal4" id="cumtotal4"  class="form-control dt-input dt-full-name" />
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text"  name="cumtotal5" id="cumtotal5"  class="form-control dt-input dt-full-name" />
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text"  name="cumtotal6" id="cumtotal6"  class="form-control dt-input dt-full-name" />
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text"  name="cumtotal7" id="cumtotal7"  class="form-control dt-input dt-full-name" />
                      
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                    <input type="text"  name="cumtotal8" id="cumtotal8"  class="form-control dt-input dt-full-name" />
                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text"  name="cumtotal9" id="cumtotal9"  class="form-control dt-input dt-full-name" />
                   
                    </div></td>
           </tr>
                
           <tr>
                   <td>Time</td>
                   <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time1" placeholder="HH:MM" id="flatpickr-time1" />
                 
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time2" placeholder="HH:MM" id="flatpickr-time2" />
                        
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time3" placeholder="HH:MM" id="flatpickr-time3" />
                     
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time4" placeholder="HH:MM" id="flatpickr-time4" />
                
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time5" placeholder="HH:MM" id="flatpickr-time5" />
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time6" placeholder="HH:MM" id="flatpickr-time6" />
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" class="form-control" name="time7" placeholder="HH:MM" id="flatpickr-time7" />
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12">
                <input type="text" class="form-control" name="time8" placeholder="HH:MM" id="flatpickr-time8" />
                </div></td>
                      
                      <td><div class="col-sm-8 col-lg-12">
                      <input type="text" class="form-control" name="time9" placeholder="HH:MM" id="flatpickr-time9" />
                    </div></td>
         </tr>

         <tr>
                   <td>Total</td>
                   <td class="sticky-col">
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="grandtotal" id="grandtotal" class="form-control dt-input dt-full-name" readonly required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                      
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"></div></td>
         </tr>
         <tr>
                   <td>Current P/R</td>
                   <td class="sticky-col">
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="current" id="current" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                        
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"></div></td>
         </tr>
         <tr>
                   <td >Required P/R</td>
                   <td  class="sticky-col">
                    <div class="col-sm-8 col-lg-12">
                    <input type="text" name="required" id="required" class="form-control dt-input dt-full-name"  required/>
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    </div>
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    
                    </div>
                </td>
                <td><div class="col-sm-8 col-lg-12"></div></td>
                      
                      <td><div class="col-sm-8 col-lg-12"></div></td>
         </tr>

         <tr>
                   <td ></td>
                   <td >
                    <div class="col-sm-8 col-lg-12">
                    <div class="form-check">
                   <input type="checkbox" name="khatrah" id="required" class="form-check-input"  />
                   <label for="required" class="form-check-label">With Khatrah</label>
</div>
                    </div>
                </td>
                <td>
                    
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <div class="form-check">
                   <input type="checkbox" name="timed" id="required" class="form-check-input"  />
                  <label for="required" class="form-check-label">Timed</label>
</div>
                    </div>
                </td>
                <td>
                 
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <div class="form-check">
                    <input type="checkbox" name="inhand" id="required" class="form-check-input"  />
                    <label for="required" class="form-check-label">Arrow in Hand</label>
</div>
                    </div>
                </td>
                <td>
               
                </td>
                <td>
                    <div class="col-sm-8 col-lg-12">
                    <input type="checkbox" name="thumb" id="required" class="form-check-input"  />
                    <label for="required" class="form-check-label">With Thumb Ring</label>
                    </div>
                </td>
             
                      
                      <td><div class="col-sm-8 col-lg-12"></div></td>
         </tr>
        
                </tbody>
            </table>
        </div>
       </div>
    </div>
    
    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary mt-3">Confirm Scores</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Select all inputs with IDs starting with "flatpickr-time"
    document.querySelectorAll('input[id^="flatpickr-time"]').forEach(input => {
        flatpickr(input, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    });
</script>
<script>

    

 let figure = @json($figure); 


    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.input-number').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total').value = total;
        document.getElementById('cumtotalfirst').value = total;
        updateCumulativeTotal();
        grandCumulativeTotal();
 
    }

    function calculateTotal2() {
        let total = 0;
        document.querySelectorAll('.input-number-2').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total2').value = total;
        updateCumulativeTotal();
        grandCumulativeTotal();
     
    }

    function calculateTotal3() {
        let total = 0;
        document.querySelectorAll('.input-number-3').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total3').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
      
    }

    function calculateTotal4() {
        let total = 0;
        document.querySelectorAll('.input-number-4').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total4').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
    }

    function calculateTotal5() {
        let total = 0;
        document.querySelectorAll('.input-number-5').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total5').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
    }

    function calculateTotal6() {
        let total = 0;
        document.querySelectorAll('.input-number-6').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total6').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
    }

    function calculateTotal7() {
        let total = 0;
        document.querySelectorAll('.input-number-7').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total7').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
    }

    function calculateTotal8() {
        let total = 0;
        document.querySelectorAll('.input-number-8').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total8').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
    }

    function calculateTotal9() {
        let total = 0;
        document.querySelectorAll('.input-number-9').forEach(input => {
            total += parseFloat(input.value) || 0; // Convert input value to float or use 0 if empty
        });
        document.getElementById('total9').value = total; // Update total field
        updateCumulativeTotal();
        grandCumulativeTotal();
    }

    function updateCumulativeTotal() {
        let total1 = parseFloat(document.getElementById('total').value) || 0;
        let total2 = parseFloat(document.getElementById('total2').value) || 0;
        let total3 = parseFloat(document.getElementById('total3').value) || 0;
        let total4 = parseFloat(document.getElementById('total4').value) || 0;
        let total5 = parseFloat(document.getElementById('total5').value) || 0;
        let total6 = parseFloat(document.getElementById('total6').value) || 0;
        let total7 = parseFloat(document.getElementById('total7').value) || 0;
        let total8 = parseFloat(document.getElementById('total8').value) || 0;
        let total9 = parseFloat(document.getElementById('total9').value) || 0;
        document.getElementById('grandtotal').value = total1 + total2 +  total3 + total4 +  total5 + total6  + total7 + total8 + total9;
    }

    function grandCumulativeTotal() {

        let total1 = parseFloat(document.getElementById('total').value) || 0;
        let total2 = parseFloat(document.getElementById('total2').value) || 0;
        let total3 = parseFloat(document.getElementById('total3').value) || 0;
        let total4 = parseFloat(document.getElementById('total4').value) || 0;
        let total5 = parseFloat(document.getElementById('total5').value) || 0;
        let total6 = parseFloat(document.getElementById('total6').value) || 0;
        let total7 = parseFloat(document.getElementById('total7').value) || 0;
        let total8 = parseFloat(document.getElementById('total8').value) || 0;
        let total9 = parseFloat(document.getElementById('total9').value) || 0;


        if (total1 !== 0){
            document.getElementById('current').value = total1;
            let req = figure-total1;
            document.getElementById('required').value = req/8;
        }else{
            document.getElementById('current').value = 0; 
        }
   
        if (total2 !== 0){
            let yese =  total1 + total2;
            let req = figure-yese;
        document.getElementById('cumtotal2').value = yese;
        document.getElementById('current').value = yese/2 ;
        document.getElementById('required').value = req/7;
        }

        if (total3 !== 0){
            let yese =   total1 + total2 + total3 ;
            let req = figure-yese;
        document.getElementById('cumtotal3').value = yese ;
        document.getElementById('current').value = yese/3 ;
        document.getElementById('required').value = req/6;
        }

        if (total4 !== 0){
            let yese = total1 + total2 + total3  + total4  ;
            let req = figure-yese;
        document.getElementById('cumtotal4').value = yese ;
        document.getElementById('current').value = yese/4 ;
        document.getElementById('required').value = req/5;
        }
        if (total5 !== 0){
            let yese =  total1 + total2 + total3 + total4 + total5;
            let req = figure-yese;
        document.getElementById('cumtotal5').value = yese;
        document.getElementById('current').value = yese/5 ;
        document.getElementById('required').value = req/4;
        }
        if (total6 !== 0){
            let yese =  total1 + total2 + total3 + total4 + total5 + total6 ;
            let req = figure-yese;
        document.getElementById('cumtotal6').value = yese;
        document.getElementById('current').value = yese/6;
        document.getElementById('required').value = req/3;
        }
        if (total7 !== 0){
            let yese = total1 + total2 + total3 + total4 + total5 + total6 + total7 ;
            let req = figure-yese;
        document.getElementById('cumtotal7').value = yese;
        document.getElementById('current').value = yese/7;
        document.getElementById('required').value = req/2;
        }
        if (total8 !== 0){
            let yese = total1 + total2 + total3  + total4 + total5 + total6 + total7 + total8 ;
            let req = figure-yese;
        document.getElementById('cumtotal8').value = yese;
        document.getElementById('current').value = yese/8;
        document.getElementById('required').value = req/1;
        }

        if (total9 !== 0){
            let yese = total1 + total2 + total3  + total4 + total5 + total6 + total7 + total8 + total9 ;
            let req = figure-yese;
        document.getElementById('cumtotal9').value = yese;
        document.getElementById('current').value = yese/9;
        document.getElementById('required').value = req;    
        }
       
    }


    
</script>
              <!--/ DataTable with Buttons -->  
@endsection