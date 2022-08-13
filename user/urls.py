from django.urls import path, include
from . import views

urlpatterns = [
    path('<str:username>',views.userpage, name="profile_page"),
]