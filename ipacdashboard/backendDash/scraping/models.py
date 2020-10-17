from django.db import models

# Create your models here.
from django.db import models
from djangotoolbox.fields import DictField, ListField
from django.contrib.auth.models import (
    BaseUserManager, AbstractBaseUser, AbstractUser
)
class Census_Code_Data(models.Model):
    District_Census_2001_Code           =       models.CharField(max_length=150)
    District_Census_2011_Code           =       models.CharField(max_length=150)
    District_Code                       =       models.CharField(max_length=150)
    District_Name                       =       models.CharField(max_length=150)
    SubDistrict_Census_Code_2001_Code   =       models.CharField(max_length=150)
    SubDistrict_Census_Code_2011_Code   =       models.CharField(max_length=150)
    SubDistrict_Code                    =       models.CharField(max_length=150)
    SubDistrict_Name                    =       models.CharField(max_length=150)
    Village_Census_2001_Code            =       models.CharField(max_length=150)
    Village_Census_2011_Code            =       models.CharField(max_length=150)
    Village_Code                        =       models.CharField(max_length=150)
    Village_Name                        =       models.CharField(max_length=150)






