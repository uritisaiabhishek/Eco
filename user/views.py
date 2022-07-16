from django.shortcuts import render

# Create your views here.
def home(request):
    if request.method == 'POST':
        post_content = request.POST.get('post_content')
        image = request.FILES.get("post_image")
        user = request.user
        print(post_content,image,user)
    return render(request, 'user/postfeed.html')

def userpage(request):
    return render(request, 'user/profile.html')