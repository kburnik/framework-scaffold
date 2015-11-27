<?php

class ModelMocker {

  private static $dataDriverClass = 'InMemoryDataDriver';

  private static function CreateDataDriver($modelClassName = null) {
    if (self::$dataDriverClass == 'MySQLDataDriver') {
      assert($modelClassName != null);
      $dataDriverClass = "{$modelClassName}DataDriver";
      assert(class_exists($dataDriverClass));
    } else {
      $dataDriverClass = self::$dataDriverClass;
    }
    return new $dataDriverClass();
  }

  public static function SetDataDriverClass($dataDriverClass) {
    self::$dataDriverClass = $dataDriverClass;
  }

  public static function GetDataDriverClass($dataDriverClass) {
    return self::$dataDriverClass;
  }

  public static function InjectModelDataDriver(EntityModel $model) {
    $entityModelClassName = get_class($model);
    $dataDriver = self::CreateDataDriver($entityModelClassName);

    if (!($dataDriver instanceOf InMemoryDataDriver)) {
      $entityClassName = preg_replace('/Model$/', '', $entityModelClassName);
      SurogateDataDriver::SetRealDataDriver(new MySQLDataDriver());
      $qdp = Project::GetQDP();
      EntityBuilder::BuildEntity(
          $entityClassName, $dataDriver, null, true, false);
      $model->truncate();
    }

    EntityModel::InjectDataDriver($model, $dataDriver);
  }

  public static function InitializeMockModelData() {
  }

}
