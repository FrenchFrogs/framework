#Architecture

##Directories

###Core
/src/Core is the main directoy of the framework, it containe the "Factory" class and all the trait for link the models to your pollywog.

###Polliwog
/src/Pollywog contain polliwogs

###Model
/src/Model contain all models you can use in a polliwog. You must use trait to use it.

##Syntax

We use some simples rules to name attribute and method :

### Boolean

Name must begin with **is_**, **can_**, **has_** or other verbs that lead to a question with a yes/no response

*ex :*

 - **is_** valid,
 - **has_** children,
 - **can_** render

For boolean attribute, here are the method we expect :
(is|has|can) + name of the variable

*ex : *
```php
    class foo
    {
    	protected $is_valid = false;

		public function isValid()
		{
			return $this->is_valid;
		}
    }
```


### Container / Array

Name must be at plural.

For array attribute, here are the methods we expect :

####Global method

 - **set** + Plural name : global setter
 - **get** + Plural name : global getter
 - **clear** + Plural name : Empty the array

####Singular hash method  - if you need index into the container

 - **add** + singular name : Add a single value in the container
 - **remove** + singular name  : Remove a nsingle value from the container
 - **has** + singular name : Return TRUE if the value exist in the container
 - **get** + singular name : Return the value

####Stack method - if you don't need index into the container

 - **shift** + singular name :  Shift an element off the beginning of the container
 - **unshift** + singular name : Prepend one or more elements to the beginning of the container
 - **push** + singular name : Push one element onto the end of the container
 - **pop** + singular name : Pop the element off the end of the container


*ex :*

```php
    class foo
    {
	    protected $children = [];

		public function setChildren(array $children)
		{
			$this->children = $children
			return $this;
		}

		public function getChildren()
		{
			return $this->children
		}

		public function clearChildren()
		{
			$this->children  = [];
			return $this;
		}

		public function addChild($index, $value)
		{
			$this->children[$index] = $value;
			return $this;
		}

		public function hasChild($index)
		{
			return array_key_exists($index, $this->children);
		}

		public function removeChild($index)
		{
			if (!$this->hasChild($index)){
				throw new \Exception('index not found in container : ' . $index);
			}

			unset($this->children[$index]);
			return $this;
		}

		public function getChild($index)
		{
			if (!$this->hasChild($index)){
				throw new \Exception('index not found in container : ' . $index);
			}

			return $this->children[$index];
		}

		public function shiftChild()
		{
			return array_shift($this->children);
		}

		public function unshiftChild($value)
		{
			array_unshift($this->children, $value);
			return $this;
		}

		public function pushChild($value)
		{
			$this->children[] = $value;
			return $this;
		}

		public function popChild()
		{
			return array_pop($this->children);
		}
    }
```
