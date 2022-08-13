from email.policy import default
from django.db import models
from django.contrib.auth.models import User
from django.shortcuts import get_object_or_404
from ckeditor.fields import RichTextField

# Create your models here.
class Tag(models.Model):
  name = models.CharField(max_length=40)

  def __str__(self):
      return self.name

class Category(models.Model):
  name = models.CharField(max_length=40)

  def __str__(self):
      return self.name

class Post(models.Model):
    title = models.CharField(max_length=200, db_index=True, null=True)
    slug = models.SlugField(max_length=200, db_index=True, null=True)
    created_on = models.DateTimeField(auto_now_add=True, null=True)
    updated_on = models.DateTimeField(auto_now= True, null=True)
    category = models.ManyToManyField(Category, blank=True)
    tags = models.ManyToManyField(Tag, blank=True)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    image = models.ImageField(blank=True)
    caption = RichTextField(null=True, blank=True)
    likes = models.ManyToManyField(User, related_name='blog_posts')

    class Meta:
        ordering = ['-created_on']

    def __str__(self):
        return f"{self.user} + {self.caption[:20]}"

class Profile(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    bio = models.CharField(max_length=50)
    followers=models.IntegerField(default=0)
    following=models.IntegerField(default=0)
    profileImage = models.ImageField()
    profilebackgroundImage = models.ImageField(null=True)
    location = models.TextField(null=True)
    dob = models.DateField( null=True)
    gitlink = models.URLField(null=True)

    def __str__(self):
        return str(self.user)

class Comment(models.Model):
    post = models.ForeignKey(Post, related_name="comments", on_delete=models.CASCADE)
    name = models.ForeignKey(User, on_delete=models.CASCADE)
    caption = RichTextField(null=True, blank=True)
    created_on = models.DateTimeField(auto_now_add=True, null=True)

    def __str__(self):
        return '%s - %s' %  (self.post.title, self.name)

class Likes(models.Model):
    pass
