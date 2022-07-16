from django.shortcuts import redirect, render
from django.http import HttpResponse
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login, logout
from django.contrib import messages

# Create your views here.
def signup_view(request):
    '''signup function'''
    if request.method == 'POST':
        username = request.POST.get('signup_username')
        signup_email = request.POST.get('signup_email')
        signup_password = request.POST.get('signup_password')
        confirm_signup_password = request.POST.get('confirm_signup_password')
        print(username,signup_email,signup_password,confirm_signup_password)
        if signup_password == confirm_signup_password:
            user = User.objects.create_user(
                username = username, 
                first_name = username, 
                last_name = username, 
                email=signup_email, 
                password = signup_password
            )
            messages.success(request,  f"User {username} Created")          
            # return render(request, 'account/login.html')  
        else:
            messages.error(request,  "Passwords Did Not Match")          
    return render(request, 'account/signup.html')

def login_view(request):
    '''Login function'''
    if request.method == 'POST':
        username = request.POST.get('username')
        password = request.POST.get('password')
        print(username,password)
        user = authenticate(username = username,  password = password)
        if user is not None:
            login(request,user)
            messages.success(request,  "successfully Logged in") 
            return redirect("home_page")
        else:
            messages.error(request, "Invalid Credentials")     
            return render(request, 'account/login.html')            
    return render(request, 'account/login.html')

def logout_view(request):
    logout(request)
    messages.success(request, "Logged Out") 
    return redirect("/")