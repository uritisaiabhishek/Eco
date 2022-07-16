from django.urls import path, include
from . import views

urlpatterns = [
    path('',views.userpage, name="profile_page"),
]