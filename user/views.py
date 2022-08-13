from getpass import getuser
import profile
from django.http import HttpResponse
from django.shortcuts import redirect, render
from user.models import Category, Post, Profile, Tag, Comment, Likes
from django.contrib import messages
from django.contrib.auth.models import User
import re
from django.shortcuts import get_object_or_404

def slugify(s):
  s = s.lower().strip()
  s = re.sub(r'[^\w\s-]', '', s)
  s = re.sub(r'[\s_-]+', '-', s)
  s = re.sub(r'^-+|-+$', '', s)
  return s

# Create your views here.
def home(request):
    homeurl = request.get_host()
    user_count = User.objects.count()
    if request.method == 'POST':
        post_type = request.POST.get('post_type')
        if post_type == 'blog':
            post_title = request.POST.get('post_title')
            post_slug = slugify(post_title)
            post_content = request.POST.get('post_content')
            image = request.FILES.get("post_image")
            user = request.user
            user = Post(title=post_title ,slug= post_slug,caption = post_content, image= image, user=user)
            user.save()
            messages.success(request,  "Post Added Successfully")
        elif post_type == 'comment':    
            post = request.POST.get('post_id')
            name = request.POST.get('user_id')
            caption = request.POST.get('comment')
            print(post,name,caption)
            
            post_instance = get_object_or_404(Post, id=post)
            user_instance = get_object_or_404(User, id=name)
            new_comment = Comment()
            new_comment.post = post_instance
            new_comment.name = user_instance
            new_comment.caption = caption
            new_comment.save()
            messages.success(request,  "Commented Successfully")

    post_count = Post.objects.count()
    # like_count = Likes.objects.filter(post=1).count()
    current_post = Post.objects.filter(id=6)
    print(current_post)
    like_count = current_post.count()
    comment_count = Comment.objects.filter(post=6).count()
    tag = Tag.objects.all()
    category = Category.objects.all()
    allposts = Post.objects.all()    

    return render(request, 'user/postfeed.html', {
            'user_count': user_count,
            'post_count': post_count,
            'categories': category,
            'comment_count':comment_count,
            'like_count':like_count,
            'tags': tag,
            'posts':allposts,
            "homeurl": "http://"+homeurl,
        }
    )

def post_by_search(request):
    homeurl = request.get_host()
    if request.method == 'POST':
        searchfield = request.POST.get('searchfield')
        user_count = User.objects.count()
        post_count = Post.objects.count()
        tag = Tag.objects.all()
        category = Category.objects.all()
        postbySearch = Post.objects.filter(title__contains=searchfield)
        messages.success(request, f"You Searched for '{searchfield}'")
        return render(request, 'user/postfeed.html',
            {
                'user_count': user_count,
                'posts': postbySearch,
                'post_count': post_count,
                'categories': category,
                'tags': tag,
                "homeurl": "http://"+homeurl,
            }
        )
    else:
        return redirect("/")


def post_by_category(request,cat):
    homeurl = request.get_host()
    user_count = User.objects.count()
    post_count = Post.objects.count()
    tag = Tag.objects.all()
    category = Category.objects.all()
    cat_id = Category.objects.filter(name=cat)
    for i in cat_id:
        postbyCategory = Post.objects.filter(category=i)

    return render(request, 'user/postfeed.html',
        {
            'user_count': user_count,
            'posts': postbyCategory,
            'post_count': post_count,
            'categories': category,
            'tags': tag,
            "homeurl": "http://"+homeurl,
            "current_cat":cat
        }
    )

def userpage(request, username):
    homeurl = request.get_host()
    getUser = User.objects.filter(username = username)
    if getUser:
        profile= Profile.objects.get(user = getUser[0])
        userposts = Post.objects.filter(user=request.user)
        return render(request, 'user/profile.html',
            {
                'profile': profile,
                'posts': userposts,
                "homeurl": "http://"+homeurl,
            }
        )
    else: 
        messages.error(request, f"{username} not found")
        return redirect("/")

def post_view(request, postslug):
    homeurl = request.get_host()
    category = Category.objects.all()
    postbyCategory = Post.objects.filter(slug=postslug)
    return render(request, 'single.html',{
            'categories': category,
            'data': postbyCategory,
            "homeurl": "http://"+homeurl
        }
    )

def delete_view(request, pk):
    post = Post.objects.get(id = pk)
    post.delete()
    messages.info(request,"post deleted")
    return redirect("home_page")

def comment_delete_view(request, pk):
    comment = Comment.objects.get(id = pk)
    comment.delete()
    messages.info(request,"comment deleted")
    return redirect("home_page")

def like_post(request,pk):
    post = get_object_or_404(Post, id=request.POST.get('post_id'))
    post.likes.add(request.user)
    return redirect("home_page")
    